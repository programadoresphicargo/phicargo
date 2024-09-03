<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$idcorreo = $_POST['idcorreoup'];

$sqlUpdate = "UPDATE correos_electronicos set estado = 'inactivo' where id_correo = $idcorreo";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
