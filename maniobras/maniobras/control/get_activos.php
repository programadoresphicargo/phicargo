<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'date_order', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'partner_id', 'x_status_maniobra_retiro', 'x_status_maniobra_ingreso', 'x_eco_retiro_id', 'x_mov_bel', 'x_operador_retiro_id', 'x_terminal_bel', 'x_eco_ingreso_id', 'x_mov_ingreso_bel_id'], 'order' => 'date_order desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        '|',
        (array('x_status_maniobra_retiro', '=', "activo")),
        (array('x_status_maniobra_ingreso', '=', "activo")),
    ),),
    $kwargs
);

$json = json_encode($ids);
