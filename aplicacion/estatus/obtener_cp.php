<?php

require_once('../../odoo/odoo-conexion.php');

$name = $_POST['name'];;

$kwargs = ['fields' => ['travel', 'x_reference', 'x_ejecutivo_viaje_bel', 'x_custodia_bel', 'date_start', 'x_date_arrival_shed']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('travel_id', '=', $name),
    ),),
    $kwargs
);

$json = json_encode($ids);
file_put_contents('a.json', $json);
print($json);
