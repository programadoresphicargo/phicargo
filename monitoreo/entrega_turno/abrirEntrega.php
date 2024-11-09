<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['userID'];

$sqlInsert = "INSERT INTO entrega_turnos VALUES(NULL,'Entrega de turno','','$fechaHora','$fechaHora','',$id_usuario,'abierto','$fechaHora',NULL)";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
