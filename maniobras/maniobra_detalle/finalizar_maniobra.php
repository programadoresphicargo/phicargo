<?php
require_once('../../mysql/conexion.php');
session_start();
$cn = conectar();
$fechaHora = date('Y-m-d H:i:s');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
    $id_usuario = $_POST['id_usuario'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
    $id_usuario = $_SESSION['userID'];
}

$sql = "UPDATE maniobra set 
estado_maniobra = 'finalizada',
usuario_finalizo = $id_usuario,
fecha_finalizada = '$fechaHora'
where id_maniobra = $id_maniobra";
$resultado = $cn->query($sql);

if ($resultado) {
    echo 1;
} else {
    echo 0;
}
