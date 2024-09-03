<?php

require_once('../../../mysql/conexion.php');

$viaje_id = $_POST['viaje_id'];
$elemento_id = $_POST['elemento_id'];
$tipo_checklist = $_POST['tipo_checklist'];

$cn = conectar();
$sqlSelect = "SELECT * FROM checklist_evidencias where viaje_id = $viaje_id and elemento_id = $elemento_id and tipo_checklist = '$tipo_checklist'";
$resultSet = $cn->query($sqlSelect);

if ($resultSet) {
    $data = array();
    while ($row = $resultSet->fetch_assoc()) {
        $data[] = $row;
    }
    $jsonResult = json_encode($data);
    echo $jsonResult;
} else {
    echo "Error en la consulta: " . $cn->error;
}
$cn->close();
