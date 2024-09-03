<?php

require_once('../../mysql/conexion.php');

$referencia = $_POST['referencia'];
$unidad = $_POST['unidad'];

$cadena_sin_corchetes = str_replace(['[', ']'], '', $unidad);
$palabras = explode(' ', $cadena_sin_corchetes);
$segunda_palabra = $palabras[1];

$cn = conectar();

$sqlUnidad = "SELECT * FROM ubicaciones WHERE placas = '$segunda_palabra' ORDER BY fecha_hora DESC LIMIT 1";
$resultado = $cn->query($sqlUnidad);

if ($resultado && $resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    echo ($row['velocidad'] == 0) ? 1 : 0;
} else {
    echo "No se encontraron registros para la unidad especificada.";
}
