<?php
require_once('../../odoo/odoo-conexion.php');

$domain = [
    []
];

$domain[0][] = ['active', '=', true];
$domain[0][] = ['department_id', '=', [5, 6]];

$kwargs = ['fields' => ['id', 'name', 'state_id', 'name2', 'x_tipo_vehiculo', 'x_sucursal', 'x_tipo_vehiculo', 'x_tipo_carga', 'x_modalidad', 'x_operador_asignado']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'hr.employee',
    'search_read',
    $domain,
    $kwargs
);

echo $json = json_encode($ids);
