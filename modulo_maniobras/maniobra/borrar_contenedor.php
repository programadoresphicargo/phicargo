<?php
require_once('../../postgresql/conexion.php');
session_start();
$cn = conectarPostgresql();

$id = $_GET['id'];

$sql = "DELETE FROM maniobras_contenedores WHERE id = :id";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id' => $id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => 1]);
    } else {
        throw new Exception("No se encontró la fila para eliminar.");
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
