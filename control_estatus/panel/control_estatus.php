<?php

require_once('../../mysql/conexion.php');

$cn = conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $status = $_POST['status'];
    $tipo = $_POST['tipo'];
    $tipo_terminal = $_POST['tipo_terminal'];

    // Manejo del archivo subido
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $_FILES['avatar']['size'];
        $fileType = $_FILES['avatar']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitizar el nombre del archivo para evitar caracteres no deseados
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Definir el directorio donde se almacenará el archivo subido
        $uploadFileDir = '../../img/status/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $message = 'Archivo subido exitosamente.';
        } else {
            $message = 'Hubo un error al subir el archivo. Por favor, inténtelo de nuevo.';
        }
    } else {
        $message = 'No se ha subido ningún archivo.';
    }
}

if ($_POST['funcion'] == 'registrar') {
    $sqlInsert = "INSERT INTO status VALUES (NULL, '$status', '$tipo', '$tipo_terminal', '$dest_path', 1, 1, 1, 1, 1)";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    $id_status = $_POST['id_status'];
    $sqlUpdate = "UPDATE status set status = '$status', tipo = '$tipo', tipo_terminal = '$tipo_terminal', imagen = '$dest_path' where id_status = $id_status";
    if ($cn->query($sqlUpdate)) {
        echo 1;
    } else {
        echo 0;
    }
}
