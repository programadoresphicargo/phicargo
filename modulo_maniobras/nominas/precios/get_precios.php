<?php
require_once('../../../postgresql/conexion.php');
$cn = conectar();

$sql = "SELECT * FROM precios_maniobra";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute(); // Ejecutar la consulta primero
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC); // Luego obtener los datos

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>