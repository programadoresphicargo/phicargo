<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_acceso = $_GET['id_acceso'];
$SQL = "SELECT * FROM acceso_vehicular left join vehiculos on vehiculos.id_vehiculo = acceso_vehicular.id_vehiculo where id_acceso = $id_acceso order by acceso_vehicular.id asc";
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
