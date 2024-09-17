<?php
require_once('../../postgresql/conexion.php');

$pdo = conectar();
$id_cp = $_GET['id_cp'];

$sql = "SELECT 
maniobras.id_maniobra,
tipo_maniobra,
inicio_programado,
terminal,
hr_employee.name as nombre_operador,
fleet_vehicle.name as vehiculo,
estado_maniobra
FROM maniobras
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id
LEFT JOIN maniobras_contenedores ON maniobras_contenedores.id_maniobra = maniobras.id_maniobra
WHERE maniobras_contenedores.id_cp = :id_cp
ORDER BY maniobras.id_maniobra DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_cp' => $id_cp]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
