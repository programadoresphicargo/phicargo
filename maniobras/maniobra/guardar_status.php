<?php
require_once('../../mysql/conexion.php');

date_default_timezone_set("America/Mexico_City");
$fecha_envio = date("Y-m-d H:i:s");

$cn = conectar();

$id_cp = $_POST['id_cp'];
$id_status = $_POST['id_status'];
$placas = $_POST['placas'];
$tipo = $_POST['tipo'];
$id = $_POST['id'];

$SqlSelect = "SELECT * from ubicaciones where placas = '$placas' order by fecha_hora desc limit 1";
echo $SqlSelect;
$result = $cn->query($SqlSelect);
$row = $result->fetch_assoc();
$id_ubicacion = $row['id'];

$SqlInsert = "INSERT INTO status_maniobras VALUES(NULL,$id_cp,'$tipo',$id_ubicacion,NULL,$id_status,$id,'$fecha_envio')";
if ($cn->query($SqlInsert)) {
    echo 1;
} else {
    echo 0;
}
