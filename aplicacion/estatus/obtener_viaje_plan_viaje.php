<?php

require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];;

$kwargs = ['fields' => ['id',], 'limit' => 1];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('employee_id', '=', $id),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);