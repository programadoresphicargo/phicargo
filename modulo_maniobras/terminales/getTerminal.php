<?php
require_once('../../postgresql/conexion.php');

$id_terminal = $_GET['id_terminal'];
$pdo = conectarPostgresql();

$sql = "SELECT *
FROM maniobras_terminales
where id_terminal = $id_terminal
ORDER BY terminal DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
