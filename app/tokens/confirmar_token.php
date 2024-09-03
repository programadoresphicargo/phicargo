<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id = $_POST['id'];
$token = $_POST['token'];

$sqlSelect = "SELECT token from operadores where id = $id";
$resultado = $cn->query($sqlSelect);
$row = $resultado->fetch_assoc();

if ($row['token'] == $token) {
    echo 'NO CAMBIO TOKEN';
} else {
    $sqlUpdate = "UPDATE operadores set  token = '$token' where id = $id";
    $cn->query($sqlUpdate);
    echo 'CAMBIO';
}
