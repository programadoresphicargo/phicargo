<?php
require_once('../../mysql/conexion.php');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$cn = conectar();
$sql = "SELECT * FROM maniobra inner join flota on flota.vehicle_id = maniobra.vehicle_id where id_maniobra = $id_maniobra";
$resultado = $cn->query($sql);
while ($row = $resultado->fetch_assoc()) {
    if ($row['vehicle_id'] . '-' . $row['estado']) {
    }
}
