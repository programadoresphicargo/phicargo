<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_estadia = $_POST['id_estadia'];

$sql = "UPDATE cobro_estadias set estado = 'confirmado' where id_estadia = $id_estadia";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
