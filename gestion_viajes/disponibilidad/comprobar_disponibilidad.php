<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$sql = "SELECT * FROM viajes where id = $id_viaje";
$row = $result = $cn->query($sql)->fetch_assoc();
$placas = $row['placas'];

$sqlplacas = "SELECT * FROM viajes where placas = '$placas' and estado = 'activo'";
$resultado = $cn->query($sqlplacas);
if ($resultado->num_rows > 0) {
    echo 0;
} else {
    echo 1;
}
