<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

$sql2 = "SELECT id_cp, hr_employee.name as operador, terminal, name2
FROM maniobras_contenedores 
LEFT JOIN tms_waybill ON tms_waybill.id = maniobras_contenedores.id_cp 
LEFT JOIN maniobras ON maniobras.id_maniobra = maniobras_contenedores.id_maniobra 
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN maniobras_terminales ON maniobras_terminales.id_terminal = maniobras.id_terminal
LEFT JOIN fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id 
WHERE maniobras_contenedores.id_maniobra = :id_maniobra";

try {
    $stmt = $cn->prepare($sql2);
    $stmt->execute([':id_maniobra' => $id_maniobra]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    foreach ($data as $row2) {
        $id = $row2['id_cp'];

        $operador = $row2['operador'];
        $terminal = $row2['terminal'];
        $unidad = $row2['name2'];

        $partner_value = [
            'x_operador_retiro_id' => $operador_id,
            'x_operador_retiro' => $operador,
            'x_mov_bel' => $terminal,
            'x_inicio_programado_retiro' => $inicio_programado,
            'x_eco_retiro' => $unidad,
            'x_eco_retiro_id' => $vehicle_id,
        ];

        $values = [$id, $partner_value];

        $cambios = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
} finally {
    $cn = null;
}
