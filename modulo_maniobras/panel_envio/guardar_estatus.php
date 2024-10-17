<?php
require_once('../../postgresql/conexion.php');
require_once('../correos/metodos.php');
session_start();
$id_usuario = $_SESSION['userID'];

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$id_maniobra = $_POST['id_maniobra'];
$id_estatus = $_POST['id_estatus'];
$comentarios = $_POST['comentarios'];


if (isset($_FILES['file'])) {
    guardar_base_datos($id_maniobra, false, $id_estatus, $id_usuario, $comentarios, $_FILES['file']);
} else {
    guardar_base_datos($id_maniobra,  false, $id_estatus, $id_usuario, $comentarios, null);
}
