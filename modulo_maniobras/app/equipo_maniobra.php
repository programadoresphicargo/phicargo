<?php

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['x_eco_retiro_id', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_eco_ingreso_id', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso', 'x_motogenerador_1_retiro', 'x_motogenerador_2_retiro', 'x_motogenerador_1_ingreso', 'x_motogenerador_2_ingreso', 'x_reference', 'x_reference_2'], 'order' => 'x_inicio_programado_retiro desc'];

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
file_put_contents('ahs.json', $json);
print($json);
