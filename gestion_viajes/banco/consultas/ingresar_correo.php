<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$cliente = $_POST['idcliente'];
$nombre  = $_POST['nombre'];
$correo  = $_POST['correo'];
$tipo    = $_POST['tipo'];

$sqlInsert = "INSERT INTO correos_electronicos VALUES(NULL,$cliente,'$nombre','$correo','$tipo','activo')";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
