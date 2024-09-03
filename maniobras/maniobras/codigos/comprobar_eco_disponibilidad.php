<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'x_eco_retiro_id', 'x_eco_ingreso_id']];

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('id', '=', intval($id_cp)),
    ),),
    $kwargs
);

if ($ids) {
    $id = $ids[0]['id'];

    if ($tipo == 'Ingreso') {
        $vehiculo = $ids[0]['x_eco_ingreso_id'][0];
    }

    if ($tipo == 'Retiro') {
        $vehiculo = $ids[0]['x_eco_retiro_id'][0];
    }
} else {
    echo "No se encontraron resultados para el ID $id_cp";
}

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_eco_retiro_id', '=', $vehiculo),
        array('x_status_maniobra_retiro', '=', 'activo'),
    ),),
    $kwargs
);

$ids3 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_eco_ingreso_id', '=', $vehiculo),
        array('x_status_maniobra_ingreso', '=', 'activo'),
    ),),
    $kwargs
);

$respuesta = false;

if ($ids2) {
    $respuesta = true;
}

if ($ids3) {
    $respuesta = true;
}

echo $respuesta;
