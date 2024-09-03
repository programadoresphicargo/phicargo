<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$correo = $_POST['correo'];
$tipo = $_POST['tipo'];
$id_cliente = $_POST['id_cliente'];
$sqlSelect = "INSERT INTO correos_electronicos VALUES(NULL,$id_cliente,NULL,'$correo','$tipo','activo')";
if ($cn->query($sqlSelect)) {
    echo 1;
} else {
    echo 0;
}
