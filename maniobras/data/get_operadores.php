<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM operadores";
$resultado = $cn->query($sql);

$flotaArray = array();
while ($fila = $resultado->fetch_assoc()) {
    $flotaArray[] = $fila;
}

echo json_encode($flotaArray);
