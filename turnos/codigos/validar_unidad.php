<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$unidad = $_POST['unidad'];
$sucursal = $_POST['sucursal'];

$sql = "SELECT * FROM turnos WHERE placas ='$unidad' and cola = false and fecha_archivado IS NULL and sucursal = '$sucursal'";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
  echo 1;
} else {
  echo 0;
}
