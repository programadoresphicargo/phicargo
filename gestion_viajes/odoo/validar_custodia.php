<?php

require_once('../../odoo/odoo-conexion.php');
require_once('../../ripcord-master/ripcord.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$id_viaje = $_POST['id_viaje'];
$iniciar = true;

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
        'fields' => array('employee_id', 'waybill_ids'),
        'limit' => 1
    )
);

$json = json_encode($records);

$array = json_decode($json, true);

$allPartnersAreOne = true;

foreach ($array[0]['waybill_ids'] as $waybillId) {
    $partner_record_ids = [intval($waybillId)];
    $partner_value = [
        'x_custodia_validada' => true,
    ];
    $values = [$partner_record_ids, $partner_value];
    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    if ($partners !== true) {
        $allPartnersAreOne = false;
        break;
    }
}

if ($allPartnersAreOne) {
    echo 1;
} else {
    echo 0;
}
