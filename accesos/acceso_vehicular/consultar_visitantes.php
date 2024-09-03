<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_acceso = $_POST['id_acceso'];
$SQL = "SELECT * FROM registro_visitantes left join visitantes on visitantes.id_visitante = registro_visitantes.id_visitante where id_acceso = $id_acceso";
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
