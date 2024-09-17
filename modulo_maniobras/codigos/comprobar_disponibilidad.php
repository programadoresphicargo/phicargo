<?php
require_once('../../postgresql/conexion.php');

// Obtener el id_maniobra de POST o GET
$id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];

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
FROM maniobras m
JOIN flota f ON f.vehicle_id IN (m.vehicle_id, m.trailer1_id, m.trailer2_id, m.dolly_id, m.motogenerador_1, m.motogenerador_2)
WHERE m.id_maniobra = :id_maniobra
AND f.x_status != 'disponible'";

// Preparar la consulta
$stmt = $cn->prepare($sql);

// Pasar los parámetros
$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);

// Ejecutar la consulta
$stmt->execute();

// Iterar sobre los resultados
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['equipo'] . ' se encuentra en ' . $row['estado'] . '<br>';
}
