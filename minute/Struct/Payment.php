<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 5:01 AM
 */
namespace Minute\Struct {

    class Payment {
        /**
         * @var float
         */
        private $setup_amount;
        /**
         * @var string
         */
        private $setup_time;
        /**
         * @var float
         */
        private $rebill_amount;
        /**
         * @var string
         */
        private $rebill_time;
        /**
         * @var string
         */
        private $description;

        /**
         * Payment constructor.
         *
         * @param float $setup_amount
         * @param string $setup_time
         * @param float $rebill_amount
         * @param string $rebill_time
         * @param string $description
         */
        public function __construct(float $setup_amount = 0, string $setup_time = '', float $rebill_amount = 0, string $rebill_time = '', string $description = '') {
            $this->setup_amount     = $setup_amount;
            $this->setup_time       = $setup_time;
            $this->rebill_amount = $rebill_amount;
            $this->rebill_time   = $rebill_time;
            $this->description = $description;
        }

        /**
         * @return string
         */
        public function getDescription(): string {
            return $this->description;
        }

        /**
         * @param string $description
         *
         * @return Payment
         */
        public function setDescription(string $description): Payment {
            $this->description = $description;

            return $this;
        }

        /**
         * @return float
         */
        public function getSetupAmount(): float {
            return $this->setup_amount;
        }

        /**
         * @param float $setup_amount
         *
         * @return Payment
         */
        public function setSetupAmount(float $setup_amount): Payment {
            $this->setup_amount = $setup_amount;

            return $this;
        }

        /**
         * @return string
         */
        public function getSetupTime(): string {
            return $this->setup_time;
        }

        /**
         * @param string $setup_time
         *
         * @return Payment
         */
        public function setSetupTime(string $setup_time): Payment {
            $this->setup_time = $setup_time;

            return $this;
        }

        /**
         * @return float
         */
        public function getRebillAmount(): float {
            return $this->rebill_amount;
        }

        /**
         * @param float $rebill_amount
         *
         * @return Payment
         */
        public function setRebillAmount(float $rebill_amount): Payment {
            $this->rebill_amount = $rebill_amount;

            return $this;
        }

        /**
         * @return string
         */
        public function getRebillTime(): string {
            return $this->rebill_time;
        }

        /**
         * @param string $rebill_time
         *
         * @return Payment
         */
        public function setRebillTime(string $rebill_time): Payment {
            $this->rebill_time = $rebill_time;

            return $this;
        }
    }
}