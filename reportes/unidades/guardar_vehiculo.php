<?php
require_once('../../odoo/odoo-conexion.php');

header('Content-Type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($data === null) {
    echo json_encode(['error' => 'Datos no válidos']);
    exit;
}

$id_vehiculo = $data['id_vehiculo'];
$x_sucursal = $data['x_sucursal'];
$state_id = $data['state_id'];
$x_modalidad = $data['x_modalidad'];
$x_tipo_carga = $data['x_tipo_carga'];
$x_tipo_vehiculo = $data['x_tipo_vehiculo'];

if ($data['x_operador_asignado'] == 'false') {
    $x_operador_asignado = false;
} else {
    $x_operador_asignado = $data['x_operador_asignado'];
}

$partner_record_ids = [intval($id_vehiculo)];
$partner_value = [
    'x_sucursal' => $x_sucursal,
    'state_id' => $state_id,
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
    print_r($partners);
    echo 0;
}
