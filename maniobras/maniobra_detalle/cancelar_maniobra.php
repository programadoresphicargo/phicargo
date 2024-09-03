<?php
require_once('../../mysql/conexion.php');
session_start();
$cn = conectar();

$id_maniobra = $_GET['id_maniobra'];
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$sql = "UPDATE maniobra set 
estado_maniobra = 'cancelada',
usuario_cancelacion = $id_usuario,
fecha_cancelacion = '$fechaHora'
where id_maniobra = $id_maniobra";
$resultado = $cn->query($sql);

if ($resultado) {
    echo 1;
} else {
    echo 0;
}
