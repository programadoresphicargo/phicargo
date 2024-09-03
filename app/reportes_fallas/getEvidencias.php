<?php

require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];

$kwargs = ['fields' => ['id', 'datas']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'ir.attachment',
    'search_read',
    array(array(
        array('res_id', '=', $id),
        array('res_model', '=', 'fleet.mro.driver_report'),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);
