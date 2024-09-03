<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_viaje = $_POST['id_viaje'];

$sqlSelect1 = "WITH ultimo_registro AS (
    SELECT id_viaje, reportes_estatus_viajes.fecha_envio
    FROM reportes_estatus_viajes 
    INNER JOIN usuarios 
        ON usuarios.id_usuario = reportes_estatus_viajes.id_usuario 
    WHERE tipo = 'Monitorista' 
        AND id_viaje = $id_viaje
    ORDER BY reportes_estatus_viajes.fecha_envio DESC 
    LIMIT 1)

SELECT *, TIMESTAMPDIFF(MINUTE, fecha_envio, (NOW() - INTERVAL 6 HOUR)) AS diferencia_minutos
FROM ultimo_registro
WHERE TIMESTAMPDIFF(MINUTE, fecha_envio, (NOW() - INTERVAL 6 HOUR)) >= 60";

$sqlSelect2 = "WITH ultimo_registro AS (
    SELECT id_viaje,
	reenvios_estatus.fecha_envio
    FROM reenvios_estatus
    INNER JOIN reportes_estatus_viajes
        ON reportes_estatus_viajes.id_reporte = reenvios_estatus.id_reporte
    INNER JOIN usuarios 
        ON usuarios.id_usuario = reenvios_estatus.id_usuario 
    WHERE tipo = 'Monitorista' 
        AND id_viaje = $id_viaje
    ORDER BY reenvios_estatus.fecha_envio DESC 
    LIMIT 1)
    
SELECT *, TIMESTAMPDIFF(MINUTE, fecha_envio, (NOW() - INTERVAL 6 HOUR)) AS diferencia_minutos
FROM ultimo_registro
WHERE TIMESTAMPDIFF(MINUTE, fecha_envio, (NOW() - INTERVAL 6 HOUR)) >= 60";

$result1 = $cn->query($sqlSelect1);
$result2 = $cn->query($sqlSelect2);

if ($result1->num_rows > 0 || $result2->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
