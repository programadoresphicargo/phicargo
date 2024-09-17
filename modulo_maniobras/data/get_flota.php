<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
if (isset($_POST['fleet_type'])) {
    $fleet_type = $_POST['fleet_type'];
} else {
    $fleet_type = $_GET['fleet_type'];
}
$sql = "SELECT * FROM flota where fleet_type = '$fleet_type'";
$resultado = $cn->query($sql);

$flotaArray = array();
while ($fila = $resultado->fetch_assoc()) {
    $flotaArray[] = $fila;
}

echo json_encode($flotaArray);
