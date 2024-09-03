<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'x_eco_retiro_id', 'x_eco_ingreso_id']];

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

if ($tipo == 'Ingreso') {
    $partner = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', intval($id_cp)))),
        array(
            'fields' => array('id', 'x_status_maniobra_ingreso'),
        )
    );
} else  if ($tipo == 'Retiro') {
    $partner = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', intval($id_cp)))),
        array(
            'fields' => array('id', 'x_status_maniobra_retiro'),
        )
    );
}


$json_partner = json_encode($partner);
echo $json_partner;
