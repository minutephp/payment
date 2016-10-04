<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/10/2016
 * Time: 6:05 PM
 */
namespace Minute\Payment {

    use Auryn\Injector;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Helper\ProviderUtils;
    use Minute\Interfaces\Provider;
    use Minute\Utils\PathUtils;

    class ProviderInfo {
        /**
         * @var ProviderUtils
         */
        private $providerUtils;
        /**
         * @var Injector
         */
        private $injector;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var PathUtils
         */
        private $utils;

        /**
         * ProviderInfo constructor.
         *
         * @param ProviderUtils $providerUtils
         * @param Injector $injector
         * @param Config $config
         * @param PathUtils $utils
         */
        public function __construct(ProviderUtils $providerUtils, Injector $injector, Config $config, PathUtils $utils) {
            $this->providerUtils = $providerUtils;
            $this->injector      = $injector;
            $this->config        = $config;
            $this->utils         = $utils;
        }

        public function describe(ImportEvent $event) {
            $classes = $this->providerUtils->iterateProviders();

            foreach ($classes as $class) {
                /** @var Provider $provider */
                $name      = $this->utils->filename($class);
                $urls      = $this->providerUtils->getURLs($name);
                $provider  = $this->injector->make($class);
                $enabled   = $this->config->get("processors/$name/enabled", false);
                $results[] = ['name' => $name, 'link' => $urls['purchase'], 'fields' => $provider->getFields(), 'enabled' => $enabled];
            }

            $event->setContent($results ?? []);
        }
    }
}