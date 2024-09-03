<?php

require_once('../../odoo/odoo-conexion.php');


function removeDuplicateTravelIds($data)
{
    $uniqueTravelIds = array();
    $uniqueData = array();
    foreach ($data as $item) {
        $travelId = $item['travel_id'][0];
        if (!in_array($travelId, $uniqueTravelIds)) {
            $uniqueData[] = $item;
            $uniqueTravelIds[] = $travelId;
        }
    }
    return $uniqueData;
}

$id = $_POST['id'];
$tipo = $_POST['tipo'];

if ($tipo == 'Retiro') {
    $kwargs = ['fields' => ['name', 'x_reference', 'x_operador_retiro_id', 'x_mov_bel', 'x_eco_retiro_id', 'x_inicio_programado_retiro', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_status_maniobra_retiro', 'x_tipo_terminal_retiro'], 'limit' => 1, 'order' => 'x_inicio_programado_retiro desc'];

    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(
            array('x_operador_retiro_id', '=', $id),
            array('x_status_maniobra_retiro', '=', 'activo'),
        ),),
        $kwargs
    );

    $json = json_encode($ids);
    if (!empty($json)) {
        print($json);
    } else {
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('x_operador_retiro_id', '=', $id),
            ),),
            $kwargs
        );

        $json = json_encode($records);
        print($json);
    }
} else {
    $kwargs = ['fields' => ['name', 'x_reference', 'x_terminal_bel', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_inicio_programado_ingreso', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso', 'x_status_maniobra_ingreso', 'x_tipo_terminal_ingreso', 'travel_id'], 'limit' => 1, 'order' => 'x_inicio_programado_ingreso desc'];

    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(
            array('x_mov_ingreso_bel_id', '=', $id),
            array('x_status_maniobra_ingreso', '=', 'activo'),
        ),),
        $kwargs
    );

    if (!empty(($ids))) {
        $final = removeDuplicateTravelIds($ids);
        print(json_encode($final));
    } else {
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('x_mov_ingreso_bel_id', '=', $id),
            ),),
            $kwargs
        );

        $json = json_encode($records);
        print($json);
    }
}
