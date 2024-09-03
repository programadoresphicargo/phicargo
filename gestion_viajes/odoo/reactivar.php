<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();
$id = $_POST['id'];
$sqlCancelacion = "UPDATE viajes set estado = 'Disponible' where id = $id";
if ($cn->query($sqlCancelacion)) {

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
            'fields' => array('waybill_ids'),
        )
    );

    $json = json_encode($records);

    $array = json_decode($json, true);

    foreach ($array[0]['waybill_ids'] as $waybillId) {
        $partner_record_ids = [$waybillId];
        $partner_value = [
            'x_status_viaje' => NULL,
        ];
        $values = [$partner_record_ids, $partner_value];

        $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    }

    print_r($partners);
} else {
    echo 0;
}
