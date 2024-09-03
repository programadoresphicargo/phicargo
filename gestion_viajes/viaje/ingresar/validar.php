<?php

require_once "../../../mysql/conexion.php";

$cn = conectar();

$id = $_POST['id'];
$sqlSelect = "SELECT ESTADO FROM viajes WHERE ID = $id";
$resultSet = $cn->query($sqlSelect);
$row = $resultSet->fetch_assoc();
echo $row['ESTADO'];
