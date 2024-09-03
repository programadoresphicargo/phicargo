<?php

require_once('../../../mysql/conexion.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['password'];

$cn = conectar();
$sqlSelect = "SELECT id_usuario, usuario, passwoord, nombre, tipo from usuarios where usuario = '$usuario' and passwoord = '$contraseña'";
$resultSet = $cn->query($sqlSelect);

if ($resultSet->num_rows > 0) {
    $row = $resultSet->fetch_assoc();
    $jsonResponse = json_encode($row);
    header('Content-Type: application/json');
    echo $jsonResponse;
} else {
    $errorResponse = array("error" => "User not found");
    echo json_encode($errorResponse);
}
