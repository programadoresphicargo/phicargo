<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$data = json_decode(file_get_contents("php://input"), true);
$id_vehiculo = $data['id_vehiculo'];
$sql = "SELECT * FROM vehiculos where id_vehiculo = $id_vehiculo";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
