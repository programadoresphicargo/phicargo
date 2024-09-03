<?php

require_once('../../../mysql/conexion.php');

$pin = $_POST['pin'];

$cn = conectar();
$sqlSelect = "SELECT pin, id_usuario from usuarios where pin = $pin";
$resultSet = $cn->query($sqlSelect);

if ($resultSet->num_rows > 0) {
    $row = $resultSet->fetch_assoc();
    $jsonResponse = json_encode($row);
    $errorResponse = array("respuesta" => "correcto", "id_usuario" => $row['id_usuario']);
    echo json_encode($errorResponse);
} else {
    $errorResponse = array("respuesta" => "incorrecto");
    echo json_encode($errorResponse);
}
