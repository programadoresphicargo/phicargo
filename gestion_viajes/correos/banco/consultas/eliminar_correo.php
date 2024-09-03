<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$idcorreo = $_POST['idcorreoup'];

$sqlUpdate = "DELETE from correos_electronicos where id_correo = $idcorreo";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
