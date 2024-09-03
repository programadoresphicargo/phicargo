<?php

require_once('../../odoo/odoo-conexion.php');

$id = 2497;
$kwargs = ['fields' => ['id', 'vehicle_id', 'x_notas_operador'], 'order' => 'date desc'];

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
file_put_contents('ahs44.text', $json);
print($json);
