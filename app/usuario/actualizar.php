<?php
$id = $_POST['id'];

require_once('../../mysql/conexion.php');
$cn = conectar();

$sqlSelect = "SELECT * FROM operadores where id = '$id'";
$resultSet = $cn->query($sqlSelect);

if ($resultSet->num_rows === 1) {
    $datos = mysqli_fetch_assoc($resultSet);
    echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} else {
    echo 0;
}
