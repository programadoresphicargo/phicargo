<?php

require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];
$kwargs = ['fields' => ['name', 'id', 'vehicle_id', 'x_notas_operador', 'create_date'], 'order' => 'date desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.mro.driver_report',
    'search_read',
    array(array(
        array('id', '=', $id),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);
