<?php

require_once('../../odoo/odoo-conexion.php');

$id_viaje = intval($_POST['id_viaje']);

$kwargs = ['fields' => ['travel', 'x_reference', 'x_ejecutivo_viaje_bel', 'x_custodia_bel', 'date_start', 'x_date_arrival_shed', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'x_medida_bel', 'x_clase_bel', 'waybill_category'], 'limit' => 1];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('travel_id', '=', $id_viaje),
    ),),
    $kwargs
);

$json = json_encode($ids);
file_put_contents('ab.json', $json);
print($json);
