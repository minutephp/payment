<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class PaymentMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'payment' => ['title' => 'Payment processors', 'icon' => 'fa-cc', 'priority' => 99, 'parent' => 'e-commerce', 'href' => '/admin/processors'],
                'recent-payments' => ['title' => 'Recent payments', 'icon' => 'fa-newspaper-o', 'priority' => 4, 'parent' => 'e-commerce', 'href' => '/admin/payments']
            ];

            $event->addContent($links);
        }

        public function adminUserPanels(ImportEvent $event) {
            $links = [
                ['title' => 'User Payments', 'href' => '"/admin/users/payments/" + user.user_id', 'icon' => 'fa-dollar', 'priority' => 4],
            ];

            $event->addContent($links);
        }
    }
}