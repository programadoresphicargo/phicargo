<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_reporte = $_POST['id_reporte'];
$SQL = "SELECT * FROM reportes_app left join usuarios on usuarios.id_usuario = reportes_app.usuario_resolvio where id_reporte = $id_reporte";

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
