<?php
require_once('../../odoo/odoo-conexion.php');

if ($tipo == 'Retiro') {
    $kwargs = ['fields' => ['x_eco_retiro_id', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro','x_reference','x_operador_retiro_id'], 'order' => 'date_order desc'];
} else if ($tipo == 'Ingreso') {
    $kwargs = ['fields' => ['x_eco_ingreso_id', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso','x_reference','x_mov_ingreso_bel_id'], 'order' => 'date_order desc'];
}

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('id', '=', $id_cp)),
    ),),
    $kwargs
);

$json = json_encode($ids);
