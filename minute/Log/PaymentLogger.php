<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 4:29 PM
 */
namespace Minute\Log {

    use App\Model\MPaymentLog;
    use Minute\Event\PaymentEvent;

    class PaymentLogger {
        public function log(PaymentEvent $event) {
            $txn  = $event->getTransaction();
            $name = $event->getName();
            $data = ['user_id' => $txn->getUserId(), 'subscription_id' => $txn->getSubscriptionId(), 'transaction_id' => $txn->getTransactionId(), 'payment_event' => $name,
                     'data_json' => json_encode(array_merge($_REQUEST ?? [], $txn->getRaw())), 'status' => $txn->getStatus()];

            try {
                MPaymentLog::unguard();
                MPaymentLog::create($data);
            } catch (\Throwable $e) {
            }
        }
    }
}