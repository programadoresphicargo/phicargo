<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'x_fechaing_bel'], 'order' => 'x_llegada_patio desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>', "2023-08-01")),
        (array('travel_id', '!=', false)),
    ),),
    $kwargs
);

$json = json_encode($ids);
$bytes = file_put_contents("contenedores.json", $json);
