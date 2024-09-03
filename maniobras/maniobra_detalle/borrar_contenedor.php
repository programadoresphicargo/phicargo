<?php
require_once('../../mysql/conexion.php');
session_start();
$cn = conectar();

$id = $_GET['id'];

$sql = "DELETE FROM maniobra_contenedores where id = $id";
$resultado = $cn->query($sql);

if ($resultado) {
    echo 1;
} else {
    echo 0;
}
