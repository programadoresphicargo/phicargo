<?php

require_once('../../odoo/odoo-conexion.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$id = $_POST['id'];
$iniciar = true;

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(
        array('id', '=', $id),
    )),
    array(
        'fields' => array('employee_id', 'waybill_ids'),
        'limit' => 1
    )
);

$json = json_encode($records);

$array = json_decode($json, true);
$conductor = ($array[0]['employee_id'][0]);

foreach ($array[0]['waybill_ids'] as $waybillId) {
    $records = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(
            array('id', '=', $waybillId),
        )),
        array(
            'fields' => array('x_operador_bel_id'),
        )
    );

    $json = json_encode($records);
    $array = json_decode($json, true);
    if ($array[0]['x_operador_bel_id'] != null) {
        $operador_programado = ($array[0]['x_operador_bel_id'][0]);
        if ($conductor == $operador_programado) {
        } else {
            $iniciar = 0;
        }
    } else {
        echo 0;
    }
}

if ($iniciar == true) {
    echo 1;
} else {
    echo 0;
}
