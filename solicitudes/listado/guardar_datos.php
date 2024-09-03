<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];

$numero_celular = $_POST['numero_celular'];
$sql = "UPDATE usuarios_clientes set numero_celular = $numero_celular where id_usuario = $id_usuario";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
