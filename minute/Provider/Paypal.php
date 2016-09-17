<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 4:56 AM
 */
namespace Minute\Provider {

    use Illuminate\Support\Str;
    use Minute\Config\Config;
    use Minute\Crypto\JwtEx;
    use Minute\Error\PaymentError;
    use Minute\Event\Dispatcher;
    use Minute\Event\PaymentEvent;
    use Minute\Event\UserSignupEvent;
    use Minute\Helper\ProviderUtils;
    use Minute\Http\HttpRequestEx;
    use Minute\Interfaces\Provider;
    use Minute\Verify\PaypalVerify;
    use Minute\Struct\Payment;
    use Minute\Struct\Transaction;

    class Paypal implements Provider {
        const paypal_key = 'processors/Paypal';
        /**
         * @var Config
         */
        protected $config;
        /**
         * @var JwtEx
         */
        protected $jwt;
        /**
         * @var ProviderUtils
         */
        private $helper;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var PaypalVerify
         */
        private $verify;

        /**
         * Provider constructor.
         *
         * @param Config $config
         * @param JwtEx $jwt
         * @param ProviderUtils $helper
         * @param Dispatcher $dispatcher
         * @param PaypalVerify $verify
         */
        public function __construct(Config $config, JwtEx $jwt, ProviderUtils $helper, Dispatcher $dispatcher, PaypalVerify $verify) {
            $this->config     = $config;
            $this->jwt        = $jwt;
            $this->helper     = $helper;
            $this->dispatcher = $dispatcher;
            $this->verify     = $verify;
        }

        public function createBuyLink(int $user_id, string $ident, Payment $payment) {
            if ($business = $this->config->get(self::paypal_key . '/email')) {
                $urls    = $this->helper->getURLs('Paypal');
                $item_id = $this->helper->createIdent($user_id, $ident);
                $vars    = $this->getPaymentVars($payment);

                if (isset($vars['a1']) && ($vars['a1'] == 0) && !empty($vars['p1']) && !empty($vars['t1'])) { //work around for free trial (since paypal doesn't return tx)
                    $urls['pdt'] = sprintf('%s?hash=%s', $urls['pdt'], $this->jwt->encode((object) ['ident' => $item_id, 'tx' => 'FREE-' . Str::random(8)]));
                }

                $common = ['business' => $business, 'currency_code' => 'USD', 'no_shipping' => '1', 'no_note' => '1', 'cpp_headerback_color' => 'FFFFFF',
                           'rm' => '0', 'notify_url' => $urls['ipn'], 'return' => $urls['pdt'], 'cancel_return' => $urls['cancel'],
                           'cpp_headerborder_color' => 'FFFFFF', 'submit' => 'Pay Using PayPal >>'];

                if ($headerImage = $this->config->get(self::paypal_key . '/header_image')) {
                    $common['cpp_header_image'] = $headerImage;
                }

                $vars  = array_merge($common, $vars, ['item_name' => $payment->getDescription(), 'item_number' => $item_id]);
                $redir = sprintf('https://www.paypal.com/cgi-bin/webscr?%s', http_build_query($vars));

                return $redir;
            }

            throw new PaymentError("Paypal email address is required (please configure " . self::paypal_key . "/email)");
        }

        public function getFields() {
            return ['email' => ['type' => 'email', 'label' => 'Paypal email'],
                    'auth_token' => ['label' => 'Authorization token', 'hint' => "You can find the auth_token in Paypal's merchant settings"],
                    'header_image' => ['type' => 'url', 'label'=>'Header image', 'hint'=>'Image shown on top of checkout page (on paypal.com)']
            ];
        }

        public function handleIPN(HttpRequestEx $request) {
            if ($this->verify->VerifyIPN($request)) {
                if ($item_id = $request->getParameter('item_number')) {
                    list($user_id, $ident) = $this->helper->extractIdent($item_id);
                    $txn_type    = $request->getParameter('txn_type');
                    $txn_status  = $request->getParameter('payment_status');
                    $txn_id      = $request->getParameter('txn_id');
                    $subscr_id   = $request->getParameter('subscr_id');
                    $amount      = $request->getParameter('mc_gross') ?: 0;
                    $transaction = new Transaction($user_id, $ident, $txn_id, $subscr_id, $amount, 'IPN verify');
                    $eventFn     = function () use ($transaction) { return new PaymentEvent($transaction); };

                    if (!$this->helper->isDuplicate($txn_id)) {
                        if (preg_match('/Refunded|Reversed/', $txn_status)) {
                            $transaction->setAmount(-1 * abs($amount));
                            $this->dispatcher->fire(PaymentEvent::PAYMENT_REFUND, $eventFn());
                        } elseif (preg_match('/subscr_signup/', $txn_type)) {
                            if ($request->getParameter('mc_amount1') === "0.00") { //free trial
                                $transaction->setAmount(0);
                                $this->dispatcher->fire(PaymentEvent::PAYMENT_FREE_TRIAL, $eventFn());
                            }
                        } elseif (preg_match('/subscr_payment|web_accept/', $txn_type)) {
                            if (preg_match('/Completed|Processed|Canceled\_Reversal/ ', $txn_status)) {
                                $this->dispatcher->fire(PaymentEvent::PAYMENT_CONFIRMED, $eventFn());
                            } elseif (preg_match('/Created|Pending/', $txn_status)) {
                                $this->dispatcher->fire(PaymentEvent::PAYMENT_PROCESSING, $eventFn());
                            }
                        } elseif (preg_match('/subscr_failed|subscr_eot|subscr_cancel/', $txn_type)) {
                            $transaction->setStatus($txn_type === 'subscr_cancel' ? 'Cancel' : 'Failed');
                            $this->dispatcher->fire(PaymentEvent::PAYMENT_FAIL, $eventFn());
                        }
                    }
                }
            } else { //for logging
                $this->dispatcher->fire(PaymentEvent::PAYMENT_FAIL, new PaymentEvent((new Transaction())->setStatus('NoVerify')));
            }
        }

        public function handlePDT(HttpRequestEx $request) {
            if ($tx = $request->getParameter('tx')) {
                if ($details = $this->verify->VerifyPDT($request)) {
                    $item_number = $details['item_number'];
                    $subscr_id   = $details['subscr_id'];
                    $amount      = $details['mc_gross'];
                }
            } elseif ($hash = $request->getParameter('hash')) { //paypal doesn't return tx for free trials
                if ($details = $this->jwt->decode($hash)) {
                    $tx          = $details->tx;
                    $item_number = $details->ident;
                }
            }

            if (!empty($tx) && !empty($item_number)) {
                list($user_id, $ident) = $this->helper->extractIdent($item_number);

                if (!$user_id && !empty($details)) {
                    $event = new UserSignupEvent(array_merge($details, ['email' => $details['payer_email'], 'country' => $details['residence_country']]));
                    $this->dispatcher->fire(UserSignupEvent::USER_SIGNUP_BEGIN, $event);

                    if ($user = $event->getUser()) {
                        $user_id = $user->user_id;
                    }
                }

                if ($user_id > 0) {
                    $transaction = new Transaction($user_id, $ident, $tx, $subscr_id ?? '', $amount ?? 0, $details ?? []);

                    if (!$this->helper->isDuplicate($tx)) {
                        $this->dispatcher->fire(PaymentEvent::PAYMENT_PROCESSING, new PaymentEvent($transaction));

                        return $transaction;
                    }
                } else {
                    throw new PaymentError("Could not find user_id in payment data");
                }
            } else {
                throw new PaymentError("TX and Item number are required");
            }

            return null;
        }

        private function getPaymentVars(Payment $payment) {
            if (($payment->getSetupAmount() > 0) && empty($payment->getRebillTime())) {
                $vars = ['cmd' => '_xclick', 'amount' => sprintf("%.02f", $payment->getSetupAmount())];
            } else {
                $vars = ['cmd' => '_xclick-subscriptions', 'src' => '1', 'sra' => '1'];

                if (!empty($payment->getSetupTime())) {
                    if (preg_match('/(\d+)(\w)$/', $payment->getSetupTime(), $matches)) {
                        $vars = array_merge($vars, ['a1' => sprintf("%.02f", $payment->getSetupAmount()), 'p1' => $matches[1], 't1' => strtoupper($matches[2])]);
                    }
                }

                if (!empty($payment->getRebillTime())) {
                    if (preg_match('/(\d+)(\w)$/', $payment->getRebillTime(), $matches)) {
                        $vars = array_merge($vars, ['a3' => sprintf("%.02f", $payment->getRebillAmount()), 'p3' => $matches[1], 't3' => strtoupper($matches[2])]);
                    }
                }
            }

            return $vars;
        }
    }
}