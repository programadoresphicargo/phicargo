<?php
require_once('metodos.php');
include('../../odoo/odoo-conexion.php');

echo $_POST['id'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(array('id', '=', $_POST['id']))),
    array(
        'fields' => array('employee_id', 'vehicle_id', 'trailer1_id', 'trailer2_id', 'dolly_id'), 'order' => 'date desc'
    )
);

$json = json_encode($ids);
print_r($json);
$array = json_decode($json);
foreach ($array as $vehicle) {

    if (isset($vehicle->employee_id[0])) {
        actualizar_empleado($vehicle->employee_id[0], $_POST['id'], 'viaje');
    }

    if (isset($vehicle->vehicle_id[1])) {
        actualizar_status($vehicle->vehicle_id[0], $_POST['id'], 'viaje');
    }

    if (isset($vehicle->trailer1_id[1])) {
        actualizar_status($vehicle->trailer1_id[0], $_POST['id'], 'viaje');
    }

    if (isset($vehicle->trailer2_id[1])) {
        actualizar_status($vehicle->trailer2_id[0], $_POST['id'], 'viaje');
    }

    if (isset($vehicle->dolly_id[1])) {
        actualizar_status($vehicle->dolly_id[0], $_POST['id'], 'viaje');
    }
}
