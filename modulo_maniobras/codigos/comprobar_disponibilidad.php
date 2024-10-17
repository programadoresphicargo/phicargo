<?php
require_once('../../postgresql/conexion.php');

$id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];

$cn = conectarPostgresql();
$sql = "SELECT 
    CASE 
        WHEN f.id = m.vehicle_id THEN f.name
        WHEN f.id = m.trailer1_id THEN f.name
        WHEN f.id = m.trailer2_id THEN f.name
        WHEN f.id = m.dolly_id THEN f.name
        WHEN f.id = m.motogenerador_1 THEN f.name
        WHEN f.id = m.motogenerador_2 THEN f.name
    END AS equipo,
    f.x_status AS estado
FROM maniobras m
JOIN fleet_vehicle f ON f.id IN (m.vehicle_id, m.trailer1_id, m.trailer2_id, m.dolly_id, m.motogenerador_1, m.motogenerador_2)
WHERE m.id_maniobra = :id_maniobra
AND f.x_status != 'disponible'";

$stmt = $cn->prepare($sql);
$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
$stmt->execute();

$resultados = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultados[] = $row; 
}
echo json_encode($resultados);
