<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Payment {

    use Minute\Config\Config;
    use Minute\Error\PaymentError;
    use Minute\Event\Dispatcher;
    use Minute\Event\VoucherEvent;
    use Minute\Http\HttpResponseEx;

    class Vouchers {
        /**
         * @var HttpResponseEx
         */
        private $response;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * Vouchers constructor.
         *
         * @param HttpResponseEx $response
         * @param Config $config
         * @param Dispatcher $dispatcher
         */
        public function __construct(HttpResponseEx $response, Config $config, Dispatcher $dispatcher) {
            $this->response   = $response;
            $this->config     = $config;
            $this->dispatcher = $dispatcher;
        }

        public function load() {
            if ($code = @$_COOKIE['coupon']) {
                if ($coupons = $this->findValidCoupons($code)) {
                    foreach ($coupons as $coupon) {
                        $vouchers[] = ['product_id' => $coupon->product_id, 'comment' => $coupon->comment];
                    }
                }
            }

            echo json_encode(['vouchers' => $vouchers ?? []]);
        }

        public function apply($code) {
            if (!empty($code)) {
                if ($coupons = $this->findValidCoupons($code)) {
                    $this->response->setCookie('coupon', $code, '+1 year');

                    exit('OK');
                }
            }

            throw new PaymentError("Voucher code is invalid or expired: $code");
        }

        private function findValidCoupons($code) {
            $event = new VoucherEvent($code, 0);
            $this->dispatcher->fire(VoucherEvent::VOUCHER_VERIFY, $event);

            return $event->getValidCoupons();
        }
    }
}