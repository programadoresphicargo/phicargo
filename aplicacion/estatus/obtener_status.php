<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$SQL = "SELECT * FROM status WHERE tipo = 'viaje' AND id_status NOT IN (82, 14, 15, 18) and operador = 1";

$resultado = $cn->query($SQL);

if ($resultado) {
    $resultados_array = array();
    while ($fila = $resultado->fetch_assoc()) {
        $resultados_array[] = $fila;
    }

    $json_resultados = json_encode($resultados_array);

    echo $json_resultados;
} else {
    echo "Error en la consulta: " . $cn->error;
}

$cn->close();
