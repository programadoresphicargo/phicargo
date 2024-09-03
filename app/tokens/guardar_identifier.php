<?php
$id = $_POST['id'];
$identifier = '37d42b5c7135a0b3';

require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlUpdate = "UPDATE operadores SET identifier = '$identifier' WHERE ID = $id";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
