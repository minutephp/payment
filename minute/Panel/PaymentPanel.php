<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Panel {

    use App\Model\MPayment;
    use App\Model\MPaymentLog;
    use Carbon\Carbon;
    use Minute\Event\ImportEvent;
    use Minute\Event\PaymentEvent;

    class PaymentPanel {
        public function adminDashboardPanel(ImportEvent $event) {
            $yesterday    = Carbon::create(date('Y'), date('m'), date('d'), 0, 0, 0, 'UTC');
            $failCount    = MPaymentLog::where('created_at', '>', $yesterday)->where('payment_event', '=', PaymentEvent::PAYMENT_FAIL)->count();
            $oldPayers    = MPayment::select('user_id')->where('amount', '>', 0)->where('created_at', '<', $yesterday)->get();
            $upgradeCount = MPayment::where('amount', '>', 0)->where('created_at', '>', $yesterday)->whereNotIn('user_id', $oldPayers->toArray())->count();
            $totalAmount  = MPayment::where('created_at', '>', $yesterday)->sum('amount');

            $panels = [
                ['type' => 'positive', 'title' => 'Total Payments', 'stats' => "\$$totalAmount so far", 'icon' => 'fa-dollar', 'priority' => 2, 'href' => '/admin/payments', 'cta' => 'View payments..',
                 'bg' => 'bg-green'],
                ['type' => 'positive', 'title' => 'New payments', 'stats' => "$upgradeCount upgrades", 'icon' => 'fa-thumbs-up', 'priority' => 3, 'href' => '/admin/payments',
                 'cta' => 'View payments..',
                 'bg' => 'bg-green'],
                ['type' => 'negative', 'title' => 'Attrition', 'stats' => "$failCount cancels", 'icon' => 'fa-thumbs-down', 'priority' => 2, 'href' => '/admin/payments/cancels',
                 'cta' => 'View cancels..',
                 'bg' => 'bg-red']
            ];

            $event->addContent($panels);
        }
    }
}