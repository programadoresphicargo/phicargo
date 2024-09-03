<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_operador = $_POST['id_operador'];
$id_mascota = $_POST['id_mascota'];
$fechaHora = date('Y-m-d H:i:s');

$sqlSelect = "INSERT INTO votos VALUES(NULL,$id_operador,$id_mascota,'$fechaHora')";
if ($cn->query($sqlSelect)) {
    echo 1;
}
