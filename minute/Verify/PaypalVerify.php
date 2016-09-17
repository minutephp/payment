<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 5/5/2015
 * Time: 6:58 PM
 */

namespace Minute\Verify {

    use GuzzleHttp\Client;
    use Minute\Config\Config;
    use Minute\Error\PaymentError;
    use Minute\Http\HttpRequestEx;
    use Minute\Payment\Providers\Paypal;

    class PaypalVerify {
        private $cert = '';
        private $url  = 'https://www.paypal.com/cgi-bin/webscr';
        /**
         * @var Config
         */
        private $config;

        /**
         * PaypalVerify constructor.
         *
         * @param Config $config
         */
        public function __construct(Config $config) {
            $this->config = $config;
        }

        /**
         * @param HttpRequestEx $request
         *
         * @return bool
         */
        public function VerifyIPN(HttpRequestEx $request) {
            $client = new Client();
            $client->setDefaultOption('verify', $this->getCert());

            $query    = array_merge(['cmd' => '_notify-validate'], $request->getParameters());
            $response = $client->get($this->getUrl(), ['query' => $query]);
            $body     = $response->getBody()->getContents();

            return !empty($body) && ($body === 'VERIFIED');
        }

        /**
         * @param HttpRequestEx $request
         *
         * @return array
         * @throws PaymentError
         */
        public function VerifyPDT(HttpRequestEx $request) {
            $client = new Client();
            $client->setDefaultOption('verify', $this->getCert());

            if ($at = $this->config->get(Paypal::paypal_key . '/auth_token')) {
                $query    = ['cmd' => '_notify-synch', 'tx' => $request->getParameter('tx'), 'at' => $at];
                $response = $client->get($this->getUrl(), ['query' => $query]);
                $body     = $response->getBody()->getContents();
                $parts    = explode("\n", $body, 2);
                $status   = trim($parts[0]);
                $info     = parse_ini_string($parts[1]);
                $pass     = !empty($status) && ($status === 'SUCCESS');

                return $pass ? $info : false;
            }

            throw new PaymentError("Paypal authentication token is not defined");
        }

        /**
         * @return string
         */
        public function getCert() {
            return !empty($this->cert) ? $this->cert : false;
        }

        /**
         * @param string $cert
         */
        public function setCert($cert) {
            $this->cert = $cert;
        }

        /**
         * @return string
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * @param string $url
         */
        public function setUrl($url) {
            $this->url = $url;
        }
    }
}