<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 5:25 AM
 */
namespace Minute\Struct {

    class Transaction {
        /**
         * @var int
         */
        private $user_id;
        /**
         * @var string
         */
        private $ident;
        /**
         * @var string
         */
        private $transactionId;
        /**
         * @var string
         */
        private $subscriptionId;
        /**
         * @var float
         */
        private $amount;
        /**
         * @var string
         */
        private $status;
        /**
         * @var array
         */
        private $raw;

        /**
         * Transaction constructor.
         *
         * @param int $user_id
         * @param string $ident
         * @param string $transactionId
         * @param string $subscriptionId
         * @param float $amount
         * @param string $status
         * @param array $raw
         */
        public function __construct(int $user_id = 0, string $ident = '', string $transactionId = '', string $subscriptionId = '', float $amount = 0, string $status = '', array $raw = []) {
            $this->user_id        = $user_id;
            $this->ident          = $ident;
            $this->transactionId  = $transactionId;
            $this->subscriptionId = $subscriptionId;
            $this->amount         = $amount;
            $this->status         = $status;
            $this->raw = $raw;
        }

        /**
         * @return array
         */
        public function getRaw(): array {
            return $this->raw;
        }

        /**
         * @param array $raw
         *
         * @return Transaction
         */
        public function setRaw(array $raw): Transaction {
            $this->raw = $raw;

            return $this;
        }

        /**
         * @return int
         */
        public function getUserId(): int {
            return $this->user_id;
        }

        /**
         * @param int $user_id
         *
         * @return Transaction
         */
        public function setUserId(int $user_id): Transaction {
            $this->user_id = $user_id;

            return $this;
        }

        /**
         * @return string
         */
        public function getIdent(): string {
            return $this->ident;
        }

        /**
         * @param string $ident
         *
         * @return Transaction
         */
        public function setIdent(string $ident): Transaction {
            $this->ident = $ident;

            return $this;
        }

        /**
         * @return string
         */
        public function getTransactionId(): string {
            return $this->transactionId;
        }

        /**
         * @param string $transactionId
         *
         * @return Transaction
         */
        public function setTransactionId(string $transactionId): Transaction {
            $this->transactionId = $transactionId;

            return $this;
        }

        /**
         * @return string
         */
        public function getSubscriptionId(): string {
            return $this->subscriptionId;
        }

        /**
         * @param string $subscriptionId
         *
         * @return Transaction
         */
        public function setSubscriptionId(string $subscriptionId): Transaction {
            $this->subscriptionId = $subscriptionId;

            return $this;
        }

        /**
         * @return float
         */
        public function getAmount(): float {
            return $this->amount;
        }

        /**
         * @param float $amount
         *
         * @return Transaction
         */
        public function setAmount(float $amount): Transaction {
            $this->amount = $amount;

            return $this;
        }

        /**
         * @return string
         */
        public function getStatus(): string {
            return $this->status;
        }

        /**
         * @param string $status
         *
         * @return Transaction
         */
        public function setStatus(string $status): Transaction {
            $this->status = $status;

            return $this;
        }
    }
}