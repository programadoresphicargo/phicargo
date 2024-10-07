<?php
require_once('../../postgresql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$cn = conectarPostgresql();

$SqlSelect = "SELECT * FROM maniobras where estado_maniobra = 'activa'";
$resultado = $cn->query($SqlSelect);
while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {

    echo 'Maniobra ' . $row['id_maniobra'] . '<br>';
    $id_maniobra = $row['id_maniobra'];
    $vehicle_id = $row['vehicle_id'];

    $sqlVehicle = "SELECT * FROM fleet_vehicle where id = $vehicle_id";
    $resultado2 = $cn->query($sqlVehicle);
    $row2 = $resultado2->fetch(PDO::FETCH_ASSOC);
    $placas = $row2['license_plate'];
    $ultimo_envio = $row['ultimo_envio'];

    if ((minutos_transcurridos(date("$ultimo_envio"), date($hora)) > 1) || $ultimo_envio == null) {
        guardar_base_datos($id_maniobra, $placas);
    } else {
        guardar_base_datos($id_maniobra, $placas);
    }
}
