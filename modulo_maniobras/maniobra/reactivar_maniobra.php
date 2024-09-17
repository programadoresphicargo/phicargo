<?php
require_once('../../postgresql/conexion.php'); // Asegúrate de que la conexión es con PostgreSQL
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectar();

$id_maniobra = $data['id_maniobra'];

// Preparar la consulta con parámetros
$sql_update_maniobra = "UPDATE maniobra 
                        SET estado_maniobra = 'borrador' 
                        WHERE id_maniobra = :id_maniobra";

$stmt = $cn->prepare($sql_update_maniobra);

// Bind del parámetro
$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);

// Ejecutar la consulta y verificar el resultado
if ($stmt->execute()) {
    echo json_encode(1); // Devolver JSON
} else {
    echo json_encode(0); // Devolver JSON en caso de error
}
