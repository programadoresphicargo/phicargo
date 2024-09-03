<?php

require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];;

$kwargs = ['fields' => ['id', 'date', 'user_id', 'name', 'vehicle_id', 'trailer1_id', 'dolly_id', 'route_id', 'partner_id', 'date_start_real'], 'limit' => 1];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('employee_id', '=', $id),
        array('partner_id', '!=', false),
    )),
    $kwargs
);

$json = json_encode($ids);
print($json);
