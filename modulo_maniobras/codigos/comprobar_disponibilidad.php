<?php
require_once('../../mysql/conexion.php');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$cn = conectar();
$sql = "SELECT 
    CASE 
        WHEN f.vehicle_id = m.vehicle_id THEN f.name
        WHEN f.vehicle_id = m.trailer1_id THEN f.name
        WHEN f.vehicle_id = m.trailer2_id THEN f.name
        WHEN f.vehicle_id = m.dolly_id THEN f.name
		WHEN f.vehicle_id = m.motogenerador_1 THEN f.name
        WHEN f.vehicle_id = m.motogenerador_2 THEN f.name
    END AS equipo,
    f.estado AS estado
FROM maniobra m
JOIN flota f ON f.vehicle_id IN (m.vehicle_id, m.trailer1_id, m.trailer2_id, m.dolly_id, m.motogenerador_1, m.motogenerador_2)
WHERE m.id_maniobra = $id_maniobra
AND f.estado != 'disponible'";
$resultado = $cn->query($sql);
while ($row = $resultado->fetch_assoc()) {
    echo $row['equipo'] . ' se encuentra en ' . $row['estado'];
}
