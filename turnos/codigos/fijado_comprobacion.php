<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_turno = $_POST['id_turno'];

$sqlSelect = "SELECT fijado from turnos where id_turno = $id_turno";
$result = $cn->query($sqlSelect);
$row = $result->fetch_assoc();

if ($row['fijado'] == true) {
    echo 1;
} else {
    echo 0;
}
