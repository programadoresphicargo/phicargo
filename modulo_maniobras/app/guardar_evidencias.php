<?php
require_once('../../postgresql/conexion.php'); // Asegúrate de que la conexión es con PostgreSQL
$cn = conectarPostgresql();

$id_maniobra = $_POST['id_maniobra'];
$tipo = $_POST['tipo'];
$id_usuario = $_POST['id_usuario'];
$id_elemento = $_POST['id_elemento'];

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$targetDir = "../../maniobras_evidencias/M_$id_maniobra/";
if (!is_dir($targetDir)) {
    if (mkdir($targetDir, 0777, true)) {
    } else {
    }
} else {
}

$uploadedFiles = [];

if (isset($_FILES['image'])) {
    $uploadDirectory = $targetDir;

    foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['image']['name'][$key];
        $file_path = $uploadDirectory . $file_name;
        $ruta = 'M_' . $id_maniobra . '/' . $file_name;

        if (move_uploaded_file($tmp_name, $file_path)) {
            // Consulta preparada para insertar evidencias en PostgreSQL
            $sqlEvi = "INSERT INTO maniobras_evidencias 
                        (id_maniobra, id_elemento, tipo, nombre_archivo, ruta_archivo, fecha_hora, id_usuario) 
                        VALUES (:id_maniobra, :id_elemento, :tipo, :nombre_archivo, :ruta_archivo, :fecha_hora, :id_usuario)";

            $stmt = $cn->prepare($sqlEvi);
            // Enlazamos los parámetros para evitar inyecciones SQL
            $stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
            $stmt->bindParam(':id_elemento', $id_elemento, PDO::PARAM_INT);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':nombre_archivo', $file_name);
            $stmt->bindParam(':ruta_archivo', $ruta);
            $stmt->bindParam(':fecha_hora', $fechaHoraActual);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $uploadedFiles[] = $file_name; // Agrega el nombre de archivo a la lista de archivos subidos con éxito
            }
        }
    }
}

// Verifica si todos los archivos se cargaron correctamente
if (count($_FILES["image"]["tmp_name"]) == count($uploadedFiles)) {
    echo json_encode(1);
} else {
    echo json_encode(0);
}
