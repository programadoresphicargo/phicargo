<?php

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['travel_id', 'x_enlace_cp'], 'order' => 'x_inicio_programado_retiro desc'];

$id_maniobra = $_POST['id_maniobra'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('id', '=', $id_maniobra),
    ),),
    $kwargs
);

$json = json_encode($ids);
$data = json_decode($json, true);

if ($data[0]["x_enlace_cp"] == true) {
    if (isset($data[0]["travel_id"][0])) {
        $primer_travel_id = $data[0]["travel_id"][0];

        $kwargs = ['fields' => ['travel_id', 'id', 'x_reference'], 'order' => 'x_inicio_programado_retiro desc'];

        $ids = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('travel_id', '=', $primer_travel_id),
                array('id', '!=', $id_maniobra),
            ),),
            $kwargs
        );

        $json = json_encode($ids);
        $data = json_decode($json, true);
        print($json);
    } 
}
