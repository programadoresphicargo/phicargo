<?php

require_once('../../../mysql/conexion.php');
$cn = conectar();
$correo = $_POST['correo'];
$id_cliente = $_POST['id_cliente'];
$sqlSelect = "SELECT * FROM correos_electronicos where correo = '$correo' and id_cliente = $id_cliente";
$result = $cn->query($sqlSelect);

if ($result->num_rows > 0) {
    echo 0;
} else {
    echo 1;
}
