<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'manage') {

    $params = $_REQUEST;

    list($orders, $params) = fn_get_order_status_history($params, Registry::get('settings.Appearance.admin_elements_per_page'));

    Tygh::$app['view']->assign([
        'orders' => $orders,
        'search' => $params
        ]);

    if (empty($orders) && defined('AJAX_REQUEST')) {
        Tygh::$app['ajax']->assign('force_redirection', fn_url('order_status_history.manage'));
    }
}
