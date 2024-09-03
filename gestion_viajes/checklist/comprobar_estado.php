<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];

$sql = "SELECT salida FROM checklist_flota where viaje_id = $id_viaje group by salida";
$result = $cn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $json_data = json_encode($data);
    echo $json_data;
} else {
    echo $json_data = '[{"salida":"disponible"}]';
}
