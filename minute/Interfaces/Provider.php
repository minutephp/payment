<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 4:58 AM
 */

namespace Minute\Interfaces {

    use Minute\Http\HttpRequestEx;
    use Minute\Struct\Payment;

    interface Provider {
        public function createBuyLink(int $user_id, string $ident, Payment $payment);

        public function handleIPN(HttpRequestEx $request);

        public function handlePDT(HttpRequestEx $request);

        public function getFields();
    }
}