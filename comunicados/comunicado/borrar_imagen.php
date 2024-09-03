<?php
require_once('../../mysql/conexion.php');

$id_comunicado = $_POST['id_comunicado'];
$nombre = $_POST['nombre'];

$cn = conectar();
$sqlInsert = "DELETE FROM comunicados_fotos where id_comunicado = $id_comunicado and nombre = '$nombre'";
$resultado = $cn->query($sqlInsert);
if ($resultado) {
    $imagenPath = '../fotos/' . $id_comunicado . '/' . $nombre;
    if (file_exists($imagenPath)) {
        unlink($imagenPath);
        echo 'La imagen ha sido eliminada correctamente.';
    } else {
        echo 'La imagen no existe en el servidor.';
    }
} else {
    echo 0;
}
