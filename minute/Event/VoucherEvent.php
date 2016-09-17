<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/10/2016
 * Time: 1:10 PM
 */
namespace Minute\Event {

    class VoucherEvent extends Event {
        const VOUCHER_VERIFY = "voucher.verify";
        /**
         * @var
         */
        private $code;
        /**
         * @var
         */
        private $productId;

        /**
         * @var array
         */
        private $validCoupons;

        /**
         * VoucherEvent constructor.
         *
         * @param $code
         * @param $productId
         */
        public function __construct($code, $productId) {
            $this->code      = $code;
            $this->productId = $productId;
        }

        /**
         * @return mixed
         */
        public function getValidCoupons() {
            return $this->validCoupons;
        }

        /**
         * @param mixed $validCoupons
         *
         * @return VoucherEvent
         */
        public function setValidCoupons($validCoupons) {
            $this->validCoupons = $validCoupons;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getProductId() {
            return $this->productId;
        }

        /**
         * @param mixed $productId
         *
         * @return VoucherEvent
         */
        public function setProductId($productId) {
            $this->productId = $productId;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCode() {
            return $this->code;
        }

        /**
         * @param mixed $code
         *
         * @return VoucherEvent
         */
        public function setCode($code) {
            $this->code = $code;

            return $this;
        }
    }
}