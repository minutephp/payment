<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 3/16/2015
 * Time: 9:49 PM
 */

namespace Minute\Event {

    use Minute\Struct\Transaction;

    class PaymentEvent extends Event {
        const PAYMENT_CONFIRMED  = "payment.confirmed";
        const PAYMENT_PROCESSING = "payment.processing"; //for PDT
        const PAYMENT_REFUND     = "payment.refund";
        const PAYMENT_FAIL       = "payment.fail";
        const PAYMENT_FREE_TRIAL = "payment.free.trial";

        /**
         * @var Transaction
         */
        private $transaction;

        /**
         * PaymentEvent constructor.
         *
         * @param Transaction $transaction
         */
        public function __construct(Transaction $transaction) {
            $this->transaction = $transaction;
        }

        /**
         * @return Transaction
         */
        public function getTransaction(): Transaction {
            return $this->transaction;
        }
    }
}