<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_usuario = $_POST['idusuario'];

$usuario = $_POST['usernameup'];
$passwoord = $_POST['passwoordup'];
$nombre_real = $_POST['nameup'];
$tipo = $_POST['tipoup'];
$estado = $_POST['estadoup'];
$correo = $_POST['correoup'];
$pin = $_POST['pinup'];

$sqlUpdate = "UPDATE usuarios set usuario = '$usuario', passwoord = '$passwoord', nombre = '$nombre_real', tipo = '$tipo', estado = '$estado', correo = '$correo', pin = $pin where id_usuario = $id_usuario";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
