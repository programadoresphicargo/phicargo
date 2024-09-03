<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_operador = $_POST['id_operador'];
$SQL = "SELECT * FROM reportes_app where id_operador = $id_operador order by fecha_creacion desc";

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
