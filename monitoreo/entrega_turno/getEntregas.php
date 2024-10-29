<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$fecha = $_GET['fecha'];
$sql = "SELECT
entrega_turnos.id_entrega,
entrega_turnos.abierto,
entrega_turnos.estado,
usuarios.nombre as nombre_usuario 
FROM entrega_turnos 
inner join usuarios on usuarios.id_usuario = entrega_turnos.id_usuario 
where date(fecha_inicio) = '$fecha' 
order by fecha_inicio desc";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
