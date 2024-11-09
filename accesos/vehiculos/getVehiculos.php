<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT * FROM vehiculos order by fecha_creacion desc";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
