<?php
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$sql = "SELECT 
maniobras.id_maniobra,
maniobras.id_terminal,
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

ur.nombre AS usuarioregistro,
usuario_inicio.nombre AS usuarioactivacion,
usuario_finalizo.nombre AS usuariofinalizacion

FROM maniobras
LEFT JOIN hr_employee ON hr_employee.id = maniobras.operador_id
LEFT JOIN fleet_vehicle AS flota_principal ON flota_principal.id = maniobras.vehicle_id
LEFT JOIN fleet_vehicle AS flota_trailer1 ON flota_trailer1.id = maniobras.trailer1_id
LEFT JOIN fleet_vehicle AS flota_trailer2 ON flota_trailer2.id = maniobras.trailer2_id
LEFT JOIN fleet_vehicle AS flota_dolly ON flota_dolly.id = maniobras.dolly_id
LEFT JOIN fleet_vehicle AS flota_motogenerador_1 ON flota_motogenerador_1.id = maniobras.motogenerador_1
LEFT JOIN fleet_vehicle AS flota_motogenerador_2 ON flota_motogenerador_2.id = maniobras.motogenerador_2
LEFT JOIN usuarios as ur on ur.id_usuario = maniobras.usuario_registro
LEFT JOIN usuarios as usuario_inicio on usuario_inicio.id_usuario = maniobras.usuario_activacion
LEFT JOIN usuarios as usuario_finalizo on usuario_finalizo.id_usuario = maniobras.usuario_finalizo

where id_maniobra = :id_maniobra
order by inicio_programado desc";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id_maniobra' => $id_maniobra]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
