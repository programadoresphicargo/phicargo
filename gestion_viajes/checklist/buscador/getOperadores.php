<?php

require_once('../../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT nombre_operador from operadores where activo = true order by nombre_operador asc";
$resultSet = $cn->query($sqlSelect);

if ($resultSet) {
    $operadores = array();

    while ($row = $resultSet->fetch_assoc()) {
        $operadores[] = $row;
    }

    $jsonOperadores = json_encode($operadores, JSON_PRETTY_PRINT);

    if ($jsonOperadores !== false) {
        echo $jsonOperadores;
    } else {
        echo "Error al convertir a JSON.";
    }

    $resultSet->free();
} else {
    echo "Error en la consulta: " . $cn->error;
}

$cn->close();
