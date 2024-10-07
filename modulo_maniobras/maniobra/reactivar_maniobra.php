<?php
require_once('../../postgresql/conexion.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectarPostgresql();

$id_maniobra = $data['id_maniobra'];
$sql_update_maniobra = "UPDATE maniobras
                        SET estado_maniobra = 'borrador' 
                        WHERE id_maniobra = :id_maniobra";

$stmt = $cn->prepare($sql_update_maniobra);

$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(1);
} else {
    echo json_encode(0);
}
