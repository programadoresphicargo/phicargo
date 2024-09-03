<?php

require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');

$id_op       = $_POST['id'];
$nombre_op   = $_POST['nombre'];
$id_viaje    = (int)$_POST['id_viaje_plan'];

$cn = conectar();

if (!empty($uid)) {
    $partner_record_ids = [$id_viaje];
    $partner_value = [
        'x_operador_bel_id' => $id_op,
        'x_operador_bel' => $nombre_op,
    ];
    $values = [$partner_record_ids, $partner_value];
    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    $sqlUpdate = "UPDATE turnos_veracruz set asignado = 'true' where id_operador = $id_op";
    $cn->query($sqlUpdate);
    echo 1;
} else {
    echo 0;
}
