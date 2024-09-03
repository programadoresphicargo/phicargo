<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$id_usuario = $_POST['id_usuario'];
$tipo_checklist = $_POST['tipo_checklist'];
$tipo = 'firma_' . $tipo_checklist;

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$imagePath = '../../../checklist_evidencias/' . $id_viaje;

if (!is_dir($imagePath)) {
    mkdir($imagePath, 0777, true);
}

$imageName = '/' . date('Y-m-d_H-i-s') . '-firma.jpg';
$imageFullPath = $imagePath . $imageName;
$ruta = $id_viaje . $imageName;

if (move_uploaded_file($_FILES['imageBytes']['tmp_name'], $imageFullPath)) {
    $sqlnsert = "INSERT INTO checklist_evidencias VALUES(NULL,$id_viaje,'$tipo',NULL,'$imageName','$ruta','$fechaHoraActual',$id_usuario)";
    $logFilePath = 'archivo_sql.txt'; 
    if (file_put_contents($logFilePath, $sqlnsert)) {
        if ($cn->query($sqlnsert)) {
            echo 'Imagen guardada exitosamente';
        } else {
            echo 'Error al guardar la imagen';
        }
    } else {
        echo 'Error al guardar la consulta SQL en el archivo';
    }
} else {
    echo 'Error al guardar la imagen';
}
