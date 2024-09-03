<?php
require_once('../../odoo/odoo-conexion.php');
$fechaHora = date("Y-m-d H:i:s");
session_start();

try {
    $x_terminal_bel = $_POST['x_terminal_bel'];
    $x_tipo_terminal_ingreso = $_POST['x_tipo_terminal_ingreso'];

    if ($_POST['x_inicio_programado_ingreso'] == '') {
        $x_inicio_programado_ingreso = false;
    } else {
        $x_inicio_programado_ingreso = $_POST['x_inicio_programado_ingreso'];
    }

    $x_enlace = $_POST['x_enlace'];
    $x_enlace = filter_var($x_enlace, FILTER_VALIDATE_BOOLEAN);
    $x_mov_ingreso_bel_id = $_POST['x_mov_ingreso_bel_id'];
    $x_eco_ingreso_id = $_POST['x_eco_ingreso_id'];
    $x_remolque_1_ingreso = $_POST['x_remolque_1_ingreso'];
    $x_remolque_2_ingreso = $_POST['x_remolque_2_ingreso'];
    $x_dolly_ingreso = $_POST['x_dolly_ingreso'];
    $x_motogenerador_1_ingreso = $_POST['x_motogenerador_1_ingreso'];
    $x_motogenerador_2_ingreso = $_POST['x_motogenerador_2_ingreso'];

    if ($_POST['x_cp_enlazada'] == '') {
        $x_cp_enlazada = false;
    } else {
        $x_cp_enlazada = intval($_POST['x_cp_enlazada']);
    }

    $arreglo_cadena = $_POST['arreglo'];
    $arreglo_elementos = explode(',', $arreglo_cadena);
    $partner_record_ids = array_map('intval', $arreglo_elementos);

    $partner_value = [
        'x_mov_ingreso_bel_id' => $x_mov_ingreso_bel_id,
        'x_terminal_bel' => $x_terminal_bel,
        'x_tipo_terminal_ingreso' => $x_tipo_terminal_ingreso,
        'x_inicio_programado_ingreso' => $x_inicio_programado_ingreso,
        'x_eco_ingreso_id' => $x_eco_ingreso_id,
        'x_remolque_1_ingreso' => $x_remolque_1_ingreso,
        'x_remolque_2_ingreso' => $x_remolque_2_ingreso,
        'x_dolly_ingreso' => $x_dolly_ingreso,
        'x_motogenerador_1_ingreso' => $x_motogenerador_1_ingreso,
        'x_motogenerador_2_ingreso' => $x_motogenerador_2_ingreso,
        'x_enlace_cp' => $x_enlace,
        'x_programo_ingreso_usuario' => $_SESSION['nombre'],
        'x_programo_ingreso_fecha' => $fechaHora,
        'x_cp_enlazada' => $x_cp_enlazada,
    ];
    $values = [$partner_record_ids, $partner_value];

    $cambios = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

    if ($cambios) {
        echo 1;
    } else {
        echo 0;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

if (count($partner_record_ids) >= 2) {
    $segundo_elemento = $partner_record_ids[1];
    if ($partner_record_ids[0] != $partner_record_ids[1]) {
        $partner_value = [
            'x_inicio_programado_ingreso' => false,
        ];
        $values = [$segundo_elemento, $partner_value];

        $cambios = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

        if ($cambios) {
            //echo 1;
        } else {
            //echo 0;
        }
    }
}


