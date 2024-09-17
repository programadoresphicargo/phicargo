<?php
require_once('../../odoo/odoo-conexion.php');

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Error al decodificar JSON: " . json_last_error_msg();
    exit;
}

$selectedMonth = $data['month'];

$mes = $selectedMonth;
$año = '2024';

function obtenerPrimerYUltimoDia($mes, $año)
{
    $primerDia = new DateTime("$año-$mes-01");
    $ultimoDia = clone $primerDia;
    $ultimoDia->modify('last day of this month');
    return [
        'primerDia' => $primerDia->format('Y-m-d'),
        'ultimoDia' => $ultimoDia->format('Y-m-d'),
    ];
}

$dias = obtenerPrimerYUltimoDia($mes, $año);

$kwargs = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'date_order', 'partner_id', 'x_mov_bel', 'x_eco_retiro', 'x_operador_retiro', 'x_terminal_bel'], 'order' => 'date_order asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>', $dias['primerDia'])),
        (array('date_order', '<', $dias['ultimoDia'])),
        (array('state', '!=', 'cancel')),
    ),),
    $kwargs
);

$json = json_encode($ids);
$data = json_decode($json, true);
echo $json;
