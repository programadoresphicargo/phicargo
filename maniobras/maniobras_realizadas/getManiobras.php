<?php
require_once('../../odoo/odoo-conexion.php');

$id_operador = $_POST['id_operador'];
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$kwargs = ['fields' => ['id', 'name', 'x_reference', 'x_inicio_programado_ingreso', 'x_eco_ingreso_id', 'dangerous_cargo', 'x_mov_ingreso_bel_id', 'x_enlace_cp', 'travel_id', 'x_eco_retiro_id', 'x_operador_retiro_id', 'x_solicitud_enlazada', 'x_cp_enlazada', 'x_ingreso_pagado', 'x_retiro_pagado', 'x_inicio_programado_retiro'], 'order'  => 'x_inicio_programado_ingreso asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('x_operador_retiro_id', '=', $id_operador)),
        (array('x_inicio_programado_retiro', '!=', false)),
        (array('x_inicio_programado_retiro', '>=', $inicio)),
        (array('x_inicio_programado_retiro', '<=', $fin)),
    ),),
    $kwargs
);

$json2 = json_encode($ids);

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(
        array(
            array('x_mov_ingreso_bel_id', '=', $id_operador),
            array('x_inicio_programado_ingreso', '!=', false),
            array('x_inicio_programado_ingreso', '>=', $inicio),
            array('x_inicio_programado_ingreso', '<=', $fin),
        ),
    ),
    $kwargs
);

$json = json_encode($ids);
