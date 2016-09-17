<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller {

    use Minute\Http\HttpRequestEx;
    use Minute\Payment\Processor;
    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class ProcessPDT {
        /**
         * @var Processor
         */
        private $processor;

        /**
         * ProcessIPN constructor.
         *
         * @param Processor $processor
         */
        public function __construct(Processor $processor) {
            $this->processor = $processor;
        }

        public function index(string $processor, HttpRequestEx $_request) {
            $provider = $this->processor->getProcessor($processor);
            $provider->handlePDT($_request);
        }
    }
}