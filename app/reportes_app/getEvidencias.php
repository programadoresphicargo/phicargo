<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$res_id = $_POST['res_id'];
$SQL = "SELECT * FROM files where res_id = $res_id";

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

file_put_contents('ahs.json', $json_resultados);
