<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$fecha_inicio = '2024-01-01';
$fecha_fin = '2024-08-01';

$sql = "SELECT
v.referencia,
v.fecha_inicio,
rv.id_viaje,
rv.id_usuario,
e.name,
COUNT(DISTINCT rv.id_estatus) AS estatus_enviados,
(COUNT(DISTINCT rv.id_estatus) / 6.0) * 100 AS porcentaje_estatus,
GROUP_CONCAT(DISTINCT s.status ORDER BY s.status SEPARATOR ', ') AS estatus_encontrados
FROM
reportes_estatus_viajes rv
INNER JOIN
status s ON s.id_status = rv.id_estatus
INNER JOIN
viajes v ON v.id = rv.id_viaje
INNER JOIN
empleados e ON e.id = rv.id_usuario
WHERE
rv.id_estatus IN (3, 4, 5, 6, 7, 8) 
AND
v.fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_fin'
GROUP BY
rv.id_viaje,
rv.id_usuario
ORDER BY rv.id_estatus, v.fecha_inicio DESC";

$resultado = $cn->query($sql);

$datos = array();
if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        $datos[] = $row;
    }
} else {
    echo json_encode(array("error" => "Error en la consulta"));
    exit();
}

header('Content-Type: application/json');
echo json_encode($datos);
