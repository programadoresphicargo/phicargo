<?php
require_once('../../odoo/odoo-conexion.php');

if ($_POST['tipo'] == 'Retiro') {
    $partner = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', $_POST['id_cp']))),
        array(
            'fields' => array('id', 'x_operador_retiro_id', 'x_eco_retiro_id', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro'),
        )
    );
} else {
    $partner = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', $_POST['id_cp']))),
        array(
            'fields' => array('id', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso'),
        )
    );
}

$json = json_encode($partner);
$decoded_partner = json_decode($json, true);
if ($decoded_partner !== null) {
    foreach ($decoded_partner as $key => $value) {
        if ($_POST['tipo'] == 'Retiro') {
            comprobar_operador($value['x_operador_retiro_id'][0]);
            comprobar($value['x_eco_retiro_id'][0]);

            if ($value['x_remolque_1_retiro'] != false) {
                comprobar($value['x_remolque_1_retiro'][0]);
            }
            if ($value['x_remolque_2_retiro'] != false) {
                comprobar($value['x_remolque_2_retiro'][0]);
            }
            if ($value['x_dolly_retiro'] != false) {
                comprobar($value['x_dolly_retiro'][0]);
            }
        } else {
            comprobar_operador($value['x_mov_ingreso_bel_id'][0]);
            comprobar($value['x_eco_ingreso_id'][0]);
            if ($value['x_remolque_1_ingreso'] != false) {
                comprobar($value['x_remolque_1_ingreso'][0]);
            }
            if ($value['x_remolque_2_ingreso'] != false) {
                comprobar($value['x_remolque_2_ingreso'][0]);
            }
            if ($value['x_dolly_ingreso'] != false) {
                comprobar($value['x_dolly_ingreso'][0]);
            }
        }
    }
} else {
    echo "Error al decodificar el JSON.";
}

function comprobar($id_vehicle)
{
    include('../../odoo/odoo-conexion.php');
    $partner2 = $models->execute_kw(
        $db,
        $uid,
        $password,
        'fleet.vehicle',
        'search_read',
        array(array(array('id', '=', $id_vehicle))),
        array(
            'fields' => array('id', 'name', 'x_status'),
        )
    );

    $json = json_encode($partner2);
    $decoded_partner = json_decode($json, true);
    if ($decoded_partner !== null) {
        foreach ($decoded_partner as $key => $value) {
            if ($value['x_status'] == false || $value['x_status'] == 'disponible') {
            } else {
                echo 'Equipo: ' . $value['name'] . ' en ' . $value['x_status'] . ' ';;
            }
        }
    } else {
        echo "Error al decodificar el JSON.";
    }
}

function comprobar_operador($id_operador)
{
    include('../../odoo/odoo-conexion.php');
    $partner2 = $models->execute_kw(
        $db,
        $uid,
        $password,
        'hr.employee',
        'search_read',
        array(array(array('id', '=', $id_operador))),
        array(
            'fields' => array('id', 'name', 'x_status'),
        )
    );

    $json = json_encode($partner2);
    $decoded_partner = json_decode($json, true);
    if ($decoded_partner !== null) {
        foreach ($decoded_partner as $key => $value) {
            if ($value['x_status'] == false || $value['x_status'] == 'disponible') {
            } else {
                echo 'Operador: ' . $value['name'] . ' en ' . $value['x_status'] . ' ';
            }
        }
    } else {
        echo "Error al decodificar el JSON.";
    }
}
