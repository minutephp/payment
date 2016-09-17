<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Users {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class Payments {

        public function index (RouteEx $_route) {
            return (new View('', [], false))->setAdditionalLayoutFiles(['Global'])->with(new Helper('MinuteExtras'));
        }
	}
}