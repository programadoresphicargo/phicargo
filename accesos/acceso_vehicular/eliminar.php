<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id = $_POST['id'];
$SQL = "DELETE FROM registro_visitantes where id = $id";
if ($cn->query($SQL)) {
    echo 1;
} else {
    echo 0;
}
