<?php
require_once('../../postgresql/conexion.php');

$pdo = conectarPostgresql();

$sql = "SELECT *
FROM maniobras_terminales
ORDER BY id_terminal DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
