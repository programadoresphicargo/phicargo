<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$id_operador = $_POST['id_operador'];

$sql = "SELECT 
COUNT(DISTINCT CASE 
    WHEN reportes_estatus_viajes.id_estatus IN (3, 4, 5, 6, 7, 8) 
    THEN reportes_estatus_viajes.id_estatus 
    ELSE NULL 
END) AS status_count,
ROUND(
    (COUNT(DISTINCT CASE 
        WHEN reportes_estatus_viajes.id_estatus IN (3, 4, 5, 6, 7, 8) 
        THEN reportes_estatus_viajes.id_estatus 
        ELSE NULL 
    END) * 100.0 / 6), 
2) AS porcentaje_cumplimiento
FROM 
reportes_estatus_viajes 
INNER JOIN 
status 
ON status.id_status = reportes_estatus_viajes.id_estatus 
WHERE 
id_viaje = $id_viaje
AND id_usuario = $id_operador
ORDER BY 
fecha_envio DESC";

$result = $cn->query($sql);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo "0 resultados";
}
