<?php
require_once("../../mysql/conexion.php");

$cn = conectar();
$usuario = $_POST['username'];
$nombre = $_POST['name'];
$contraseña = $_POST['passwoord'];
$tipo = $_POST['tipo'];
$correo = $_POST['correo'];
$pin = $_POST['pin'];

function JSON2Array($data)
{
    return  (array) json_decode(stripslashes($data));
}

$sqlInsert = "INSERT INTO usuarios VALUES(NULL,'$usuario','$nombre','$contraseña','$tipo','Activo','$correo', $pin)";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
