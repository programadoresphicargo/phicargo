<?php
require_once('../../postgresql/conexion.php');
$cn = conectar();

if (isset($_GET['estado_maniobra'])) {
    $estado_maniobra = $_GET['estado_maniobra'];
    $unidad = '';
} else {
    $estado_maniobra = $_POST['estado_maniobra'];
    $unidad = $_POST['unidad'];
}

$sql = "SELECT maniobras.*,
hr_employee.name as nombre_operador,
fleet_vehicle.name as unidad, 
STRING_AGG(maniobras_contenedores.id_cp::TEXT, ',' ORDER BY maniobras_contenedores.id_cp) AS contenedores_ids
FROM maniobras
LEFT JOIN fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN maniobras_contenedores ON maniobras_contenedores.id_maniobra = maniobras.id_maniobra
WHERE estado_maniobra = :estado_maniobra
GROUP BY maniobras.id_maniobra, hr_employee.name, fleet_vehicle.name";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':estado_maniobra' => $estado_maniobra]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
