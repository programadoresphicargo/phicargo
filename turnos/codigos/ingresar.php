<?php

require_once "../../mysql/conexion.php";
require_once "../algoritmos/algoritmos.php";

session_start();
$id_usuario = $_SESSION['userID'];

$cn = conectar();
$id_operador = $_POST['id_operador'];
$placas = $_POST['placas'];
$fecha_llegada = $_POST['fecha_llegada'];
$hora_llegada = $_POST['hora_llegada'];
$comentarios = $_POST['comentarios'];
$sucursal = $_POST['sucursal'];

insertar_turno($cn, $id_operador, $placas, $fecha_llegada, $hora_llegada, $comentarios, $sucursal, $id_usuario);
