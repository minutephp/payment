<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 5:14 AM
 */
namespace Minute\Helper {

    use App\Model\MPaymentIdent;
    use App\Model\MPaymentLog;
    use Minute\Config\Config;
    use Minute\Error\PaymentError;
    use Minute\Event\ImportEvent;
    use Minute\Http\HttpRequestEx;
    use Minute\Resolver\Resolver;
    use Minute\Utils\PathUtils;

    class ProviderUtils {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var HttpRequestEx
         */
        private $request;
        /**
         * @var Resolver
         */
        private $resolver;
        /**
         * @var PathUtils
         */
        private $utils;

        /**
         * ProviderHelper constructor.
         *
         * @param Config $config
         * @param HttpRequestEx $request
         * @param Resolver $resolver
         * @param PathUtils $utils
         */
        public function __construct(Config $config, HttpRequestEx $request, Resolver $resolver, PathUtils $utils) {
            $this->config   = $config;
            $this->request  = $request;
            $this->resolver = $resolver;
            $this->utils    = $utils;
        }

        public function iterateProviders() {
            if ($folders = $this->resolver->find('Minute\Provider')) {
                foreach ($folders as $folder) {
                    $classes = array_map(function ($f) { return $this->utils->filename($f); }, glob("$folder/*.php"));

                    foreach ($classes as $name) {
                        $class = "Minute\\Provider\\$name";
                        if (class_exists($class)) {
                            if ($interfaces = class_implements($class)) {
                                if (isset($interfaces['Minute\Interfaces\Provider'])) {
                                    $providers[] = $class;
                                }
                            }
                        }
                    }
                }
            }

            return $providers ?? [];
        }

        public function getURLs($processor) {
            $key    = 'private/billing';
            $prefix = '/_payments';
            $config = $this->config;

            $urls['ipn']      = $this->prefixHostName($config->get("$key/ipn_url", "$prefix/ipn/$processor"));
            $urls['pdt']      = $this->prefixHostName($config->get("$key/pdt_url", "$prefix/pdt/$processor"));
            $urls['cancel']   = $this->prefixHostName($this->request->getCookie('purchase_referrer', "/pricing"));
            $urls['purchase'] = $this->prefixHostName($config->get("$key/cart_url", "/purchase/$processor"));

            return $urls;
        }

        public function createIdent(int $user_id, string $ident) {
            MPaymentIdent::unguard();

            if ($model = MPaymentIdent::create(['user_id' => $user_id, 'ident' => $ident])) {
                return $model->getAttribute('payment_ident_id');
            } else {
                throw new PaymentError("Cannot create ident for payment");
            }
        }

        public function extractIdent(string $item_id) {
            if ($model = MPaymentIdent::where('payment_ident_id', '=', $item_id)->first()) {
                return [$model->user_id, $model->ident];
            } else {
                throw new PaymentError("Cannot find ident for item_id: $item_id");
            }
        }

        public function isDuplicate(string $txn_id): bool {
            return MPaymentLog::where('transaction_id', '=', $txn_id)->count() > 0;
        }

        protected function prefixHostName($url) {
            return preg_match('/^http/i', $url) ? $url : sprintf('%s/%s', rtrim($this->config->getPublicVars('host'), '/'), ltrim($url, '/'));
        }
    }
}