<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();

$tipo_checklist = $_POST['tipo_checklist'];
$viaje_id = $_POST['viaje_id'];
$elemento_id = $_POST['elemento_id'];
$id_usuario = $_POST['id_usuario'];

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$targetDir = "../../../checklist_evidencias/$viaje_id/";
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
        $ruta = $viaje_id . '/' . $file_name;

        if (move_uploaded_file($tmp_name, $file_path)) {
            $sqlEvi = "INSERT INTO checklist_evidencias VALUES(NULL,$viaje_id,'$tipo_checklist',$elemento_id,'$file_name','$ruta','$fechaHoraActual',$id_usuario)";
            $cn->query($sqlEvi);
            $uploadedFiles[] = $file_name;
        } else {
        }
    }
}

if (count($_FILES["image"]["tmp_name"]) == count($uploadedFiles)) {
    echo 1;
} else {
    echo 0;
}
