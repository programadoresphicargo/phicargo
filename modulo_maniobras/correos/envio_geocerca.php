<?php
require_once('../../mysql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$cn = conectar();
$SqlSelect = "SELECT * FROM maniobra where estado_maniobra = 'activa'";
$resultado = $cn->query($SqlSelect);
while ($row = $resultado->fetch_assoc()) {
    
    echo $row['id_maniobra'] . '<br>';
    $id_maniobra = $row['id_maniobra'];
    $vehicle_id = $row['vehicle_id'];
    $sqlVehicle = "SELECT * FROM flota where vehicle_id = $vehicle_id";
    $resultado2 = $cn->query($sqlVehicle);
    $row2 = $resultado2->fetch_assoc();
    $placas = $row2['plates'];
    $ultimo_envio = $row['ultimo_envio'];
    
    if ((minutos_transcurridos(date("$ultimo_envio"), date($hora)) > 1) || $ultimo_envio == null) {
        guardar_base_datos($id_maniobra, $placas);
    } else {
        guardar_base_datos($id_maniobra, $placas);
    }
}
