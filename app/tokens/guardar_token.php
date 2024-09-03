<?php
$id = $_POST['id'];
$token = $_POST['token'];

require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlUpdate = "UPDATE operadores SET TOKEN = '$token' WHERE ID = $id";

if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
