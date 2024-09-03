<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_operador = $_POST['id_operador'];
$sucursal = $_POST['sucursal'];

$sql = "SELECT * FROM turnos WHERE id_operador = '$id_operador' and cola = false and fecha_archivado IS NULL and sucursal = '$sucursal'";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
  echo 1;
} else {
  echo 0;
}
