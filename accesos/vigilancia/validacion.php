<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$pin = $_GET['pin'];
$sql = "SELECT * FROM usuarios where pin = $pin";
$resultado = $cn->query($sql);
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $response = array(
        "id_usuario" => $fila['id_usuario'],
        "respuesta" => 1
    );
} else {
    $response = array(
        "respuesta" => 0
    );
}

echo json_encode($response);
