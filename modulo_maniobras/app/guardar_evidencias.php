<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_maniobra = $_POST['id_maniobra'];
$tipo = $_POST['tipo'];
$id_usuario = $_POST['id_usuario'];
$id_elemento = $_POST['id_elemento'];

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$targetDir = "../../maniobras_evidencias/$id_maniobra/";
if (!is_dir($targetDir)) {
    if (mkdir($targetDir, 0777, true)) {
    } else {
    }
} else {
}

$uploadedFiles = [];

$uploadedFiles = array(); 

if (isset($_FILES['image'])) {
    $uploadDirectory = $targetDir; 

    foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['image']['name'][$key];
        $file_path = $uploadDirectory . $file_name;
        $ruta = $id_maniobra . '/' . $file_name;

        if (move_uploaded_file($tmp_name, $file_path)) {
            $sqlEvi = "INSERT INTO maniobras_evidencias VALUES(NULL, $id_maniobra, $id_elemento,'$tipo','$file_name','$ruta','$fechaHoraActual',$id_usuario)";
            $cn->query($sqlEvi);
            $uploadedFiles[] = $file_name; // Agrega el nombre de archivo a la lista de archivos subidos con éxito
        }
    }
}

// Verifica si todos los archivos se cargaron correctamente
if (count($_FILES["image"]["tmp_name"]) == count($uploadedFiles)) {
    echo 1;
} else {
    echo 0;
}
