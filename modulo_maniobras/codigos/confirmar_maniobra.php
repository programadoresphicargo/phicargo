<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');
$cn = conectar();

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

$sql_select = "SELECT registros_maniobras.id_maniobra FROM cp_maniobras inner join registros_maniobras on registros_maniobras.id_maniobra = cp_maniobras.id_maniobra WHERE tipo = '$tipo' AND id_cp = $id_cp and estado = 'borrador'";
$resultado = $cn->query($sql_select);
while ($row = $resultado->fetch_assoc()) {
    $id_maniobra = $row['id_maniobra'];
}
$sql_update = "UPDATE registros_maniobras SET estado = 'confirmado' WHERE id_maniobra = $id_maniobra";
$cn->query($sql_update);
