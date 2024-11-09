<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

$id_evento = $_GET['id_evento'];

$sql = "SELECT * FROM eventos_monitoreo 
inner join tipos_eventos_monitoreo on tipos_eventos_monitoreo.id_tipo_evento = eventos_monitoreo.tipo_evento 
where eventos_monitoreo.id_evento = $id_evento";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
