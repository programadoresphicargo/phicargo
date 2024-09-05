<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$sql = "SELECT 
maniobra.*,
operadores.*,
flota_principal.vehicle_id AS vehicle_id,
flota_principal.name AS vehicle_name,

flota_trailer1.vehicle_id AS trailer1_id,
flota_trailer1.name AS trailer1_name,

flota_trailer2.vehicle_id AS trailer2_id,
flota_trailer2.name AS trailer2_name,

flota_dolly.vehicle_id AS dolly_id,
flota_dolly.name AS dolly_name,

flota_motogenerador_1.vehicle_id AS motogenerador_1,
flota_motogenerador_1.name AS motogenerador_1_name,

flota_motogenerador_2.vehicle_id AS motogenerador_2,
flota_motogenerador_2.name AS motogenerador_2_name,

usuario_inicio.nombre as usuarioactivacion,
usuario_finalizo.nombre as usuariofinalizacion,
maniobra.peligroso

FROM maniobra
INNER JOIN operadores ON operadores.id = maniobra.operador_id
INNER JOIN flota AS flota_principal ON flota_principal.vehicle_id = maniobra.vehicle_id
LEFT JOIN flota AS flota_trailer1 ON flota_trailer1.vehicle_id = maniobra.trailer1_id
LEFT JOIN flota AS flota_trailer2 ON flota_trailer2.vehicle_id = maniobra.trailer2_id
LEFT JOIN flota AS flota_dolly ON flota_dolly.vehicle_id = maniobra.dolly_id
LEFT JOIN flota AS flota_motogenerador_1 ON flota_motogenerador_1.vehicle_id = maniobra.motogenerador_1
LEFT JOIN flota AS flota_motogenerador_2 ON flota_motogenerador_2.vehicle_id = maniobra.motogenerador_2

LEFT JOIN usuarios as usuario_inicio on usuario_inicio.id_usuario = maniobra.usuario_activacion
LEFT JOIN usuarios as usuario_finalizo on usuario_finalizo.id_usuario = maniobra.usuario_finalizo

where id_maniobra = $id_maniobra
order by inicio_programado desc";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
    $data = $resultado->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No se encontraron datos']);
}
