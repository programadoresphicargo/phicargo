<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_usuario = $_POST['id_usuario'];
$sql = "SELECT * FROM usuarios where id_usuario = $id_usuario";
$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();
echo $row['tipo'];
