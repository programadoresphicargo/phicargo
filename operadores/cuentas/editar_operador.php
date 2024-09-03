<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id = $_POST['id_operador'];
$password = $_POST['contraseña'];

$sqlSelect = "UPDATE operadores set passwoord = '$password' where id = $id";
if ($cn->query($sqlSelect)) {
    echo 1;
} else {
    echo 0;
}
