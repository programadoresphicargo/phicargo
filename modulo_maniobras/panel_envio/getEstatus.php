<?php
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

try {
    $sql = "SELECT * FROM status";
    $stmt = $cn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
