<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_turno = $_POST['id_turno'];
$sqlUpdate = "UPDATE turnos set fijado = true where id_turno = $id_turno";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
