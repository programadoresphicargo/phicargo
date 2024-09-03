<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT estado, count(*) as count FROM viajes group by estado";
$result = $cn->query($sqlSelect);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$json_data = json_encode($data);
echo $json_data;
