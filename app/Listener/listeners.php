<?php

/** @var Binding $binding */
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\ProviderEvent;
use Minute\Event\PurchaseEvent;
use Minute\Event\UserAdminEvent;
use Minute\Event\VoucherEvent;
use Minute\Log\PaymentLogger;
use Minute\Menu\PaymentMenu;
use Minute\Panel\PaymentPanel;
use Minute\Payment\Processor;
use Minute\Payment\ProviderInfo;
use Minute\Voucher\VoucherVerify;

$binding->addMultiple([
    //payment
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [PaymentMenu::class, 'adminLinks']],
    ['event' => AdminEvent::IMPORT_ADMIN_DASHBOARD_PANELS, 'handler' => [PaymentPanel::class, 'adminDashboardPanel']],
    ['event' => 'payment.*', 'handler' => [PaymentLogger::class, 'log']],
    ['event' => ProviderEvent::IMPORT_PROVIDERS_LIST, 'handler' => [ProviderInfo::class, 'describe']],
    ['event' => UserAdminEvent::IMPORT_ADMIN_USER_PANEL, 'handler' => [PaymentMenu::class, 'adminUserPanels']],
    ['event' => PurchaseEvent::PURCHASE_GET_LINK, 'handler' => [Processor::class, 'createBuyLink']],

    //voucher
    ['event' => VoucherEvent::VOUCHER_VERIFY, 'handler' => [VoucherVerify::class, 'verifyCoupon']],

]);