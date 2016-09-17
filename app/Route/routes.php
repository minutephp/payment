<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/processors', null, 'admin', 'm_configs[type] as configs')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'processors');
$router->post('/admin/processors', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/admin/payments', null, 'admin', 'm_payments[user_id][5] as payments ORDER BY payment_id DESC', 'm_payment_logs[payments.payment_log_id] as log', 'users[payments.user_id] as user')
       ->setReadPermission('payments', 'admin')->setDefault('payments', '*');
$router->post('/admin/payments', null, 'admin', 'm_payments as payments')
       ->setAllPermissions('payments', 'admin');

$router->get('/admin/payments/edit/{payment_id}', null, 'admin', 'm_payments[payment_id] as payments')
       ->setReadPermission('payments', 'admin')->setDefault('payment_id', '0');
$router->post('/admin/payments/edit/{payment_id}', null, 'admin', 'm_payments as payments')
       ->setAllPermissions('payments', 'admin')->setDefault('payment_id', '0');

$router->get('/admin/users/payments/{user_id}', 'Admin/Users/Payments', 'admin', 'm_payments[user_id][5] as payments ORDER BY payment_id DESC', 'm_payment_logs[payments.payment_log_id] as log')
       ->setReadPermission('payments', 'admin');
$router->post('/admin/users/payments/{user_id}', null, 'admin', 'm_payments as payments')
       ->setAllPermissions('payments', 'admin');

$router->post('/_payments/ipn/{processor}', 'ProcessIPN.php', false);
$router->get('/_payments/pdt/{processor}', 'ProcessPDT.php', false);

//voucher
$router->get('/_payments/vouchers/load', 'Payment/Vouchers@load', false)
       ->setDefault('_noView', true);
$router->post('/_payments/vouchers/apply', 'Payment/Vouchers@apply', false);