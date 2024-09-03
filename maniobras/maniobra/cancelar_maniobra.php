<?php

require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();
$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo_maniobra'];

$sql = "UPDATE maniobras set status = 'cancelado' where id_cp = $id_cp and tipo = '$tipo'";
if ($cn->query($sql)) {
    $partner_record_ids = [intval($id_cp)];

    if ($tipo == 'Ingreso') {
        $partner_value = [
            'x_status_maniobra_ingreso' => false,
        ];
    } else if ($tipo == 'Retiro') {
        $partner_value = [
            'x_status_maniobra_retiro' => false,
        ];
    }

    $values = [$partner_record_ids, $partner_value];
    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    echo 1;
} else {
    echo 0;
}
