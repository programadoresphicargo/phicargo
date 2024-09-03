<?php

require_once('../../odoo/odoo-conexion.php');

$id_viaje = $_POST['id_viaje'];

$kwargs = ['fields' => ['id', 'date', 'user_id', 'name', 'vehicle_id', 'trailer1_id', 'trailer2_id', 'dolly_id', 'route_id', 'partner_id', 'date_start_real', 'departure_id', 'x_status_viaje'], 'limit' => 1];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(
        array('id', '=', $id_viaje),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);
