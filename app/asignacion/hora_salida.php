<?php
require_once('../../mysql/conexion.php');
$id = $_POST['id'];
$cn = conectar();
$sqlSelect = "SELECT FH_ENTRADA, FH_SALIDA FROM turnos_veracruz WHERE ID_OPERADOR = '$id'";
$resultSet = $cn->query($sqlSelect);

if ($resultSet->num_rows === 1) {
    $datos = mysqli_fetch_assoc($resultSet);
    echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
}
