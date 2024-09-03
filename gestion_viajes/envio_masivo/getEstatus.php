<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT id_status, status, imagen from status where tipo = 'viaje' and monitoreo = true";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
    $datos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    echo json_encode($datos);
} else {
    echo json_encode(array());
}
