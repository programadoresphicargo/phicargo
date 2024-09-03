<?php

require_once('../../odoo/odoo-conexion.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$id = 888;

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_operador_bel_id', '=', $id),
        array('x_status_viaje', '=', ['ruta', 'planta', 'retorno'])
    )),
    array(
        'fields' => array('travel_id'),
        'limit' => 1
    )
);

$data = json_encode($records);
$array = json_decode($data, true);

if (is_array($array) && !empty($array)) {
    print($data);
} else {
    $records = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(
            array('x_operador_bel_id', '=', $id),
            (array('state', '!=', 'cancel'))
        )),
        array(
            'fields' => array('travel_id'),
            'order' => 'date_start desc',
            'limit' => 2
        )
    );

    $json = json_encode($records);
    print($json);
}
