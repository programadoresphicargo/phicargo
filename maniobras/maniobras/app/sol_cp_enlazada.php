<?php

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['x_solicitud_enlazada', 'x_cp_enlazada']];

$id_maniobra = $_POST['id_maniobra'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('id', '=', $id_maniobra),
    ),),
    $kwargs
);

$json = json_encode($ids);
$data = json_decode($json, true);

if ($_POST['opcion'] == 'Ingreso') {
    if ($data[0]["x_cp_enlazada"] != false) {
        if (isset($data[0]["x_cp_enlazada"][0])) {
            $id_maniobra2 = $data[0]["x_cp_enlazada"][0];

            $kwargs = ['fields' => ['x_reference']];

            $ids = $models->execute_kw(
                $db,
                $uid,
                $password,
                'tms.waybill',
                'search_read',
                array(array(
                    array('id', '=', $id_maniobra2),
                ),),
                $kwargs
            );

            $json = json_encode($ids);
            $data = json_decode($json, true);
            print($json);
        }
    }
} else if ($_POST['opcion'] == 'Retiro') {
    if ($data[0]["x_solicitud_enlazada"] != false) {
        if (isset($data[0]["x_solicitud_enlazada"][0])) {
            $id_maniobra2 = $data[0]["x_solicitud_enlazada"][0];

            $kwargs = ['fields' => ['x_reference']];

            $ids = $models->execute_kw(
                $db,
                $uid,
                $password,
                'tms.waybill',
                'search_read',
                array(array(
                    array('id', '=', $id_maniobra2),
                ),),
                $kwargs
            );

            $json = json_encode($ids);
            $data = json_decode($json, true);
            print($json);
        }
    }
}
