<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM registro_visitantes inner join visitantes on visitantes.id_visitante = registro_visitantes.id_visitante";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
    $datos = array();

    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    $json = json_encode($datos);

    echo $json;
} else {
    echo "No se encontraron resultados";
}
