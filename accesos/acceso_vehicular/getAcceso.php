<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id = $_POST['id'];
$SQL = "SELECT * FROM acceso_vehicular where id_acceso = $id";

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
