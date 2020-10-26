<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }


/**
 * Gets orders statuses list
 *
 * @param array  $params         Orders params
 * @param int    $items_per_page Items per page
 *
 * @return array Orders statuses history list and pagination params
 */
function fn_get_order_status_history($params = array(), $items_per_page = 0)
{
    // Set default values to input params
    $default_params = array(
        'page' => 1,
        'items_per_page' => $items_per_page
    );

    $params = array_merge($default_params, $params);

    $limit = '';

    if (!empty($params['limit'])) {
        $limit = db_quote(' LIMIT 0, ?i', $params['limit']);
    }

    $fields = array (
        '?:logs.user_id',
        '?:logs.timestamp',
        '?:logs.content',
        '?:users.firstname',
        '?:users.lastname'
    );

    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(*) FROM ?:logs WHERE action=?s", 'status');
        $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
    }

    $orders = db_get_array(
        "SELECT ?p"
        . ' FROM ?:logs'
        . ' LEFT JOIN ?:users ON ?:logs.user_id=?:users.user_id'
        . ' WHERE ?:logs.action=?s ?p',
        implode(', ', $fields), 'status', $limit
    );

    $data = [];

    foreach ($orders as $order) {
        $content = unserialize($order['content']);
        $content['status'] = explode(' -> ', $content['status']);

        $data[] = [
            'order_id' => $content['id'],
            'old_status' => $content['status'][0],
            'new_status' => $content['status'][1],
            'user_id' => $order['user_id'],
            'user_name' => "{$order['firstname']} {$order['lastname']}",
            'timestamp' => $order['timestamp']
        ];
    }

    return [$data, $params];
}
