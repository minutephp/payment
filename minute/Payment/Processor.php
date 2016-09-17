<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 5/4/2015
 * Time: 5:09 PM
 */

namespace Minute\Payment {

    use Auryn\Injector;
    use Minute\Config\Config;
    use Minute\Error\PaymentError;
    use Minute\Event\PurchaseEvent;
    use Minute\Interfaces\Provider;
    use Minute\Struct\Payment;

    class Processor {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Injector
         */
        private $injector;

        /**
         * Processor constructor.
         *
         * @param Config $config
         * @param Injector $injector
         */
        public function __construct(Config $config, Injector $injector) {
            $this->config   = $config;
            $this->injector = $injector;
        }

        /**
         * @param $name
         *
         * @return Provider
         * @throws PaymentError
         */
        public function getProcessor($name) {
            $class = sprintf('Minute\Provider\%s', $name);

            if (class_exists($class)) {
                if ($enabled = $this->config->get("processors/$name/enabled")) {
                    return $this->injector->make($class);
                } else {
                    throw new PaymentError("Payment processor is disabled: $name");
                }
            } else {
                throw new PaymentError("Payment processor not installed: $name");
            }
        }

        public function createBuyLink(PurchaseEvent $event) {
            $name      = $event->getProcessor();
            $processor = $this->getProcessor($name);

            $link = $processor->createBuyLink($event->getUserId(), $event->getIdent(), $event->getPayment());
            $event->setLink($link);
        }
    }
}