<?php

require_once('../../odoo/odoo-conexion.php');

$fecha_actual = date("Y-m-d");
$nueva_fecha = date("Y-m-d", strtotime($fecha_actual . " - 4 days"));

$kwargs = ['fields' => ['name', 'x_reference', 'x_operador_retiro_id', 'x_mov_bel', 'x_eco_retiro_id', 'x_inicio_programado_retiro', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_status_maniobra_retiro', 'x_tipo_terminal_retiro', 'x_ejecutivo_viaje_bel', 'x_status_maniobra_ingreso', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_terminal_bel', 'x_eco_bel_id', 'x_status_maniobra_retiro', 'x_status_maniobra_ingreso', 'x_inicio_programado_ingreso', 'travel_id', 'x_programo_retiro_usuario'], 'order' => 'x_inicio_programado_retiro desc'];
$kwargs2 = ['fields' => ['name', 'x_reference', 'x_operador_retiro_id', 'x_mov_bel', 'x_eco_retiro_id', 'x_inicio_programado_retiro', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_status_maniobra_retiro', 'x_tipo_terminal_retiro', 'x_ejecutivo_viaje_bel', 'x_status_maniobra_ingreso', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_terminal_bel', 'x_eco_bel_id', 'x_status_maniobra_retiro', 'x_status_maniobra_ingreso', 'x_inicio_programado_ingreso', 'travel_id', 'x_programo_ingreso_usuario'], 'order' => 'x_inicio_programado_ingreso desc'];

$unidad = $_POST['unidad'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_eco_retiro_id', 'like', $unidad),
        array('x_inicio_programado_retiro', '>', $nueva_fecha),
        array('x_status_maniobra_retiro', '=', [false, 'borrador', 'confirmada']),
        array('state', '!=', 'cancel')
    ),),
    $kwargs
);

$retiros = $ids;

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_eco_ingreso_id', 'like', $unidad),
        array('x_inicio_programado_ingreso', '>', $nueva_fecha),
        array('x_status_maniobra_ingreso', '=', [false, 'borrador', 'confirmada']),
        array('state', '!=', 'cancel')
    ),),
    $kwargs2
);

$ingresos = $ids;

function removeDuplicateTravelIds($data)
{
    $uniqueTravelIds = array();
    $uniqueData = array();

    foreach ($data as $item) {
        if (isset($item['travel_id'])) {
            $travelId = $item['travel_id'];

            if ($travelId !== false || !in_array($travelId, $uniqueTravelIds)) {
                $uniqueData[] = $item;
                if ($travelId !== false) {
                    $uniqueTravelIds[] = $travelId;
                }
            }
        } else {
            $uniqueData[] = $item;
        }
    }

    return $uniqueData;
}

$finalRetiros = $retiros;
$finalIngresos = removeDuplicateTravelIds($ingresos);

$jsonFinal = json_encode(array(
    'Retiro' => $finalRetiros,
    'Ingreso' => $finalIngresos
));

echo $jsonFinal;
