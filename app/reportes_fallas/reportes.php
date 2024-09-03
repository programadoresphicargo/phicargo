<?php

require_once('../../odoo/odoo-conexion.php');

$id_operador = $_POST['id_operador'];
$kwargs = ['fields' => ['name', 'id', 'vehicle_id', 'x_notas_operador', 'create_date', 'solved'], 'order' => 'date desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.mro.driver_report',
    'search_read',
    array(array(
        array('employee_id', '=', $id_operador),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);
