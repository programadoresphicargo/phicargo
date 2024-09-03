<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

date_default_timezone_set("America/Mexico_City");
$fecha_hora = date("Y-m-d H:i:s");

$id_cp = $_POST['id_cp'];
$id_usuario = $_POST['usuario_finalizacion'];
$tipo = $_POST['tipo'];

$sqlSelect = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo' and status = 'Activo'";
$resultado = $cn->query($sqlSelect);
$row = $resultado->fetch_assoc();
$id = $row['id'];

$SqlUpdate = "UPDATE maniobras set status = 'Finalizado', usuario_finalizacion = $id_usuario, fecha_finalizacion = '$fecha_hora'  where id = $id";
if ($cn->query($SqlUpdate)) {
    $partner_record_ids = [intval($id_cp)];
    if ($tipo == 'Retiro') {
        $partner_value = [
            'x_status_maniobra_retiro' => 'finalizado',
        ];
    } else {
        $partner_value = [
            'x_status_maniobra_ingreso' => 'finalizado',
        ];
    }
    $values = [$partner_record_ids, $partner_value];

    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    if ($partners) {
        echo 1;
    }
} else {
    echo 0;
}
