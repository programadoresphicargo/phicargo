<?php
require_once('../../postgresql/conexion.php');
$pdo = conectarPostgresql();

$sql = "SELECT *
FROM pagos_maniobras
LEFT JOIN hr_employee on hr_employee.id = pagos_maniobras.id_operador";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
