<?php
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

$operador_id = 1070;

$sql = "SELECT 
maniobras.id_maniobra,
maniobras_terminales.terminal,
maniobras.operador_id,
maniobras.tipo_maniobra,
maniobras.inicio_programado,
maniobras.estado_maniobra,
hr_employee.name as nombre_operador,
flota_principal.id AS vehicle_id,
flota_principal.name AS vehicle_name,

flota_trailer1.id AS trailer1_id,
flota_trailer1.name AS trailer1_name,

flota_trailer2.id AS trailer2_id,
flota_trailer2.name AS trailer2_name,

flota_dolly.id AS dolly_id,
flota_dolly.name AS dolly_name,

flota_motogenerador_1.id AS motogenerador_1,
flota_motogenerador_1.name AS motogenerador_1_name,

flota_motogenerador_2.id AS motogenerador_2,
flota_motogenerador_2.name AS motogenerador_2_name,

usuario_inicio.nombre as usuarioactivacion,
usuario_finalizo.nombre as usuariofinalizacion

FROM maniobras
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN fleet_vehicle AS flota_principal ON flota_principal.id = maniobras.vehicle_id
LEFT JOIN fleet_vehicle AS flota_trailer1 ON flota_trailer1.id = maniobras.trailer1_id
LEFT JOIN fleet_vehicle AS flota_trailer2 ON flota_trailer2.id = maniobras.trailer2_id
LEFT JOIN fleet_vehicle AS flota_dolly ON flota_dolly.id = maniobras.dolly_id
LEFT JOIN fleet_vehicle AS flota_motogenerador_1 ON flota_motogenerador_1.id = maniobras.motogenerador_1
LEFT JOIN fleet_vehicle AS flota_motogenerador_2 ON flota_motogenerador_2.id = maniobras.motogenerador_2
LEFT JOIN maniobras_terminales on maniobras_terminales.id_terminal = maniobras.id_terminal
LEFT JOIN usuarios as usuario_inicio on usuario_inicio.id_usuario = maniobras.usuario_activacion
LEFT JOIN usuarios as usuario_finalizo on usuario_finalizo.id_usuario = maniobras.usuario_finalizo

where operador_id = :operador_id
and estado_maniobra = 'activa'
order by inicio_programado desc
limit 1";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':operador_id' => $operador_id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
