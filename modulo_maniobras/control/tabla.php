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
hr_employee.name AS nombre_operador,
fleet_vehicle.name AS unidad,
STRING_AGG(tms_waybill.x_reference::TEXT, ',') AS contenedores_ids,
res_store.name AS sucursal
FROM maniobras
LEFT JOIN fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN maniobras_contenedores ON maniobras_contenedores.id_maniobra = maniobras.id_maniobra
LEFT JOIN tms_waybill ON tms_waybill.id = maniobras_contenedores.id_cp
LEFT JOIN res_store ON res_store.id = tms_waybill.store_id
WHERE estado_maniobra = :estado_maniobra
AND maniobras.vehicle_id::TEXT LIKE :unidad
GROUP BY maniobras.id_maniobra, hr_employee.name, fleet_vehicle.name, res_store.name";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([
        ':estado_maniobra' => $estado_maniobra,
        ':unidad' => '%' . $unidad . '%'
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
