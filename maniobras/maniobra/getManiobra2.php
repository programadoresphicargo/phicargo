<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'partner_id', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_modo_bel', 'x_mov_bel', 'x_eco_retiro_id', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_operador_retiro_id', 'x_inicio_programado_retiro', 'x_terminal_bel', 'x_eco_ingreso_id', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso', 'x_inicio_programado_ingreso', 'x_mov_ingreso_bel_id', 'x_tipo_terminal_retiro', 'x_tipo_terminal_ingreso', 'x_motogenerador_1_retiro', 'x_motogenerador_2_retiro', 'x_motogenerador_1_ingreso', 'x_motogenerador_2_ingreso', 'x_cp_enlazada']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('id', '=', $_POST['id'])),
    )),
    $kwargs
);

$json = json_encode($ids);
$products = json_decode($json, true);
