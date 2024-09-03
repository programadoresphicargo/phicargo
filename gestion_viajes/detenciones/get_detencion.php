<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_detencion = $_POST['id'];
$sql = "SELECT 
rd.*, 
v.id AS id_viaje, 
v.referencia AS referencia_viaje, 
v.estado AS estado_viaje, 
o.*, 
u.*, 
ubi.*, 
usu.*, 
CASE
    WHEN rd.fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, NOW() - INTERVAL 6 HOUR)
    ELSE TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, rd.fin_detencion)
END AS tiempo_transcurrido_minutos
FROM 
registro_detenciones AS rd 
left JOIN viajes AS v ON v.id = rd.id_viaje
left JOIN operadores AS o ON o.id = v.employee_id 
left JOIN unidades AS u ON u.placas = v.placas 
left JOIN ubicaciones AS ubi ON ubi.id = rd.id_ubicacion
left JOIN usuarios AS usu ON usu.id_usuario = rd.usuario_atendio
where id_detencion = $id_detencion";
$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();
echo json_encode($row);
