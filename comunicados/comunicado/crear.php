<?php
require_once('../../mysql/conexion.php');

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];
$textoSinEtiquetas = strip_tags($descripcion);
date_default_timezone_set('America/Mexico_City');
$fecha_hora = date('Y-m-d H:i:s');

$cn = conectar();
$sqlInsert = "INSERT INTO comunicados VALUES(NULL,'$titulo','$textoSinEtiquetas',$id_usuario,'$fecha_hora')";
$resultado = $cn->query($sqlInsert);
if ($resultado) {
    $ultimoID = $cn->insert_id;
    echo 1;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carpetaDestino = '../fotos/' . $ultimoID . '/';

        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $imagenes = $_FILES['imagenes'];

        foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
            $nombreImagen = $imagenes['name'][$key];
            $rutaImagen = $carpetaDestino . $nombreImagen;

            move_uploaded_file($tmp_name, $rutaImagen);
            $sqlInsertImagen = "INSERT INTO comunicados_fotos VALUES(NULL,$ultimoID,'$nombreImagen')";
            $cn->query($sqlInsertImagen);
        }
    }
} else {
    echo 0;
}
