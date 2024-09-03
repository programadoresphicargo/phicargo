<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$mes = $_POST['mes'];
$año = $_POST['año'];
$SQL = "SELECT id FROM operadores WHERE activo = true";
$resultado = $cn->query($SQL);

while ($row = $resultado->fetch_assoc()) {
    $id_operador = $row['id'];
    $sqlInsert = "INSERT INTO bonos(id_operador,mes,año) VALUES($id_operador,$mes,$año)";
    $cn->query($sqlInsert);
}
