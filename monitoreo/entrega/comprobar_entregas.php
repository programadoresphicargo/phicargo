<?php
session_start();
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_usuario = $_SESSION['userID'];

$sqlSelect = "SELECT * FROM entrega_turnos where id_usuario = $id_usuario and estado = 'Abierto'";
$resultado = $cn->query($sqlSelect);

if ($resultado->num_rows == 0) {
    echo 1;
} else {
    echo 0;
}
