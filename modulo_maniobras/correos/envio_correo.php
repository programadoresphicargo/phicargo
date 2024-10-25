<?php
require_once('../../postgresql/conexion.php');
require_once('metodos.php');
session_start();

$pdo = conectarPostgresql();
$fechaHora = date('Y-m-d H:i:s');

if (!isset($_POST['id_maniobra']) && !isset($_GET['id_maniobra'])) {
    throw new Exception("ID de maniobra no proporcionado.");
}

$id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];
$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['userID'];
$id_estatus = $_POST['id_estatus'];
$comentarios = $_POST['comentarios'];

if (!is_numeric($id_maniobra) || !is_numeric($id_usuario)) {
    throw new Exception("ID de maniobra o usuario no válidos.");
}

guardar_base_datos($id_maniobra, false, $id_estatus, $id_usuario, $comentarios, null);
