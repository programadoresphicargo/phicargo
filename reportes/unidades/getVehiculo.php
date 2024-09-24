<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();
$id_vehiculo = intval($_GET['id']);
$domain = [
    []
];

$domain[0][] = ['id', '=', $id_vehiculo];

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'state_id', 'name2', 'x_tipo_vehiculo', 'x_sucursal', 'x_tipo_vehiculo', 'x_tipo_carga', 'x_modalidad', 'x_operador_asignado', 'state_id']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    $domain,
    $kwargs
);

echo $json = json_encode($ids);
