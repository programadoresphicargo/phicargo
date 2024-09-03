<?php
require_once("../../mysql/conexion.php");

$id_op = $_POST['id'];

$cn = conectar();
$sqlSelect = "SELECT FH_ENTRADA FROM turnos_veracruz WHERE ID_OPERADOR = $id_op";
$resultSet = $cn->query($sqlSelect);
$row = $resultSet->fetch_assoc();
echo $row['FH_ENTRADA'];
