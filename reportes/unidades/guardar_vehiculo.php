<?php
require_once('../../odoo/odoo-conexion.php');

$id_vehiculo = $_POST['id_vehiculo'];

$x_sucursal = $_POST['x_sucursal'];
$x_modalidad = $_POST['x_modalidad'];
$x_tipo_carga = $_POST['x_tipo_carga'];
$x_tipo_vehiculo = $_POST['x_tipo_vehiculo'];
$x_operador_asignado = $_POST['x_operador_asignado'];

$partner_record_ids = [intval($id_vehiculo)];
$partner_value = [
    'x_sucursal' => $x_sucursal,
    'x_modalidad' => $x_modalidad,
    'x_tipo_carga' => $x_tipo_carga,
    'x_tipo_vehiculo' => $x_tipo_vehiculo,
    'x_operador_asignado' => $x_operador_asignado
];
$values = [$partner_record_ids, $partner_value];

$partners = $models->execute_kw($db, $uid, $password, 'fleet.vehicle', 'write', $values);

if ($partners === true) {
    echo 1;
} else {
    echo 0;
}
