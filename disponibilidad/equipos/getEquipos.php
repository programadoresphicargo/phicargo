<?php
require_once('../../postgresql/conexion.php');

try {
    $cn = conectar();
    $sql = "SELECT * FROM fleet_vehicle where state_id = 1 order by name2 asc";
    $stmt = $cn->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($resultados);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
