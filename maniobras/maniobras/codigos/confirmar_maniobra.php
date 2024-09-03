<?php
require_once('../../odoo/odoo-conexion.php');

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

if ($tipo == 'Ingreso') {
    $partner_value = [
        'x_status_maniobra_ingreso' => 'confirmada',
    ];
} else  if ($tipo == 'Retiro') {
    $partner_value = [
        'x_status_maniobra_retiro' => 'confirmada',
    ];
}
$values = [intval($id_cp), $partner_value];
$partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

print_r($partners);
