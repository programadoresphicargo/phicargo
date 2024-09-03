<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_visitante = $_POST['id_visitante'];
$sql = "DELETE FROM registro_visitantes where id_visitante = $id_visitante";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
