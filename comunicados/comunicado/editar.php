<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_comunicado = $_POST['id_comunicado'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$textoSinEtiquetas = strip_tags($descripcion);

$sqlUpdate = "UPDATE comunicados set titulo = '$titulo', descripcion = '$textoSinEtiquetas' where id_comunicado = $id_comunicado";
if ($cn->query($sqlUpdate)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carpetaDestino = '../fotos/' . $id_comunicado . '/';

        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        if (!empty($_FILES['imagenes'])) {
            $imagenes = $_FILES['imagenes'];

            foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                $nombreImagen = $imagenes['name'][$key];
                $rutaImagen = $carpetaDestino . $nombreImagen;

                move_uploaded_file($tmp_name, $rutaImagen);
                $sqlInsertImagen = "INSERT INTO comunicados_fotos VALUES(NULL,$id_comunicado,'$nombreImagen')";
                $cn->query($sqlInsertImagen);
            }
        }
    }
} else {
    echo 0;
}
