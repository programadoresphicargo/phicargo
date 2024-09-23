<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

$sql = "SELECT id_cp 
        FROM maniobras_contenedores 
        INNER JOIN tms_waybill ON tms_waybill.id = maniobras_contenedores.id_cp 
        WHERE id_maniobra = :id_maniobra";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id_maniobra' => $id_maniobra]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');

    foreach ($data as $row) {
        $id = $row['id_cp'];
        $partner_value = [
            'x_operador_retiro_id' => $operador_id,
            'x_operador_retiro' => $operador_id,
            'x_mov_bel' => $terminal,
            'x_inicio_programado_retiro' => $inicio_programado,
            'x_eco_retiro' => $vehicle_id,
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
