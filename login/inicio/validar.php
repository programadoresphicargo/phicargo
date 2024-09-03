<?php

ob_start();
session_start();

require_once(__DIR__ . '/../../mysql/conexion.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['password'];
$alerta = false;
$cn = conectar();
$sqlSelect = "SELECT id_usuario, usuario, passwoord, nombre, tipo from usuarios where usuario = '$usuario' and passwoord = '$contraseña' and estado = 'Activo'";
$resultSet = $cn->query($sqlSelect);
$row = $resultSet->fetch_assoc();
if ($resultSet->num_rows === 1 && $alerta == false) {
    echo 1;
    $_SESSION['userID'] = $row['id_usuario'];
    $_SESSION['userName'] = $row['usuario'];
    $_SESSION['userTipo'] = $row['tipo'];
    $_SESSION['logueado'] = TRUE;
    $_SESSION['nombre']   = $row['nombre'];
} else if ($resultSet->num_rows === 1 && $alerta == true && $row['id_usuario'] != 1) {
    echo 2;
} else if ($resultSet->num_rows === 1 && $alerta == true && $row['id_usuario'] == 1) {
    $_SESSION['userID'] = $row['id_usuario'];
    $_SESSION['userName'] = $row['usuario'];
    $_SESSION['userTipo'] = $row['tipo'];
    $_SESSION['logueado'] = TRUE;
    $_SESSION['nombre']   = $row['nombre'];
    echo 3;
} else {
    echo 0;
}
