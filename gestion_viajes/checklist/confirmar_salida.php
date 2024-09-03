<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];

$sql = "SELECT *,
viajes.id as travel_id,
x_reference,
x_reference_2,
flota1.vehicle_id AS remolque1_id,
flota1.name AS remolque1_info,
flota2.vehicle_id AS remolque2_id,
flota2.name AS remolque2_info,
flota3.vehicle_id AS dolly_id,
flota3.name AS dolly_info,
flota4.vehicle_id AS vehiculo_id,
flota4.name AS vehiculo_info
FROM viajes
INNER JOIN operadores ON operadores.id = viajes.employee_id
INNER JOIN unidades ON unidades.placas = viajes.placas
LEFT JOIN flota AS flota4 ON viajes.vehiculo = flota4.vehicle_id
LEFT JOIN flota AS flota1 ON viajes.remolque1 = flota1.vehicle_id
LEFT JOIN flota AS flota2 ON viajes.remolque2 = flota2.vehicle_id
LEFT JOIN flota AS flota3 ON viajes.dolly = flota3.vehicle_id
WHERE viajes.id = $id_viaje";

$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();

$vehiculo_id = $row['vehiculo_id'];
$remolque1 = $row['remolque1_id'];
$remolque2 = $row['remolque2_id'];
$dolly = $row['dolly_id'];
$reference1 = $row['x_reference'];
$reference2 = $row['x_reference_2'];

$arrayVehiculos = [
    $vehiculo_id,
    $remolque1,
    $remolque2,
    $dolly
];

$arrayContenedor = [
    $reference1,
    $reference2,
];

$validar_salida = 1;

for ($i = 0; $i < count($arrayVehiculos); $i++) {
    if ($arrayVehiculos[$i] != 0) {
        $sqlSelect = "SELECT * FROM checklist_flota where viaje_id = $id_viaje and vehiculo_id = $arrayVehiculos[$i]";
        $resultado2 = $cn->query($sqlSelect);
        if ($resultado2->num_rows > 0) {
        } else {
            $validar_salida = 0;
        }
    }
}

for ($i = 0; $i < count($arrayContenedor); $i++) {
    if ($arrayContenedor[$i] != '') {
        $sqlSelect3 = "SELECT * FROM checklist_contenedor where viaje_id = $id_viaje and contenedor_id = '$arrayContenedor[$i]'";
        $resultado3 = $cn->query($sqlSelect3);
        if ($resultado3->num_rows > 0) {
        } else {
            $validar_salida = 0;
        }
    }
}

if ($validar_salida == 0) {
    $errorResponse = array("respuesta" => $validar_salida);
    echo json_encode($errorResponse);
} else {
    $sqlS = "UPDATE checklist_flota set estado = 'salida' where viaje_id = $id_viaje";
    if ($cn->query($sqlS)) {
        $errorResponse = array("respuesta" => 'correcto');
        echo json_encode($errorResponse);
    }
}
