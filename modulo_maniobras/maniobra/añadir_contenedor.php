<?php
require_once('../../postgresql/conexion.php');

$cn = conectar();

$id_maniobra = $_GET['id_maniobra'];
$id_cp = $_GET['id_cp'];

$sql = "INSERT INTO maniobras_contenedores (id_maniobra, id_cp) VALUES (:id_maniobra, :id_cp)";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id_maniobra' => $id_maniobra, ':id_cp' => $id_cp]);
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}