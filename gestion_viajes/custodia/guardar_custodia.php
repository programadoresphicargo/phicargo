<?php

require_once('../../odoo/odoo-conexion.php');
require_once('../../ripcord-master/ripcord.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$id_viaje = $_POST['id_viaje'];
$x_empresa_custodia = $_POST['x_empresa_custodia'];
$x_nombre_custodios = $_POST['x_nombre_custodios'];
$x_datos_unidad = $_POST['x_datos_unidad'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(
        array('id', '=', $id_viaje),
    )),
    array(
        'fields' => array('waybill_ids'),
        'limit' => 1
    )
);

$json = json_encode($records);

$array = json_decode($json, true);

foreach ($array[0]['waybill_ids'] as $waybillId) {

    $partner_record_ids = [intval($waybillId)];
    $partner_value = [
        'x_empresa_custodia' => $x_empresa_custodia,
        'x_nombre_custodios' => $x_nombre_custodios,
        'x_datos_unidad' => $x_datos_unidad,
    ];
    $values = [$partner_record_ids, $partner_value];

    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

    echo print_r($partners, true);
}
