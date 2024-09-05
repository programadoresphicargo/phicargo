<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_GET['estado_maniobra'])) {
    $estado_maniobra = $_GET['estado_maniobra'];
    $unidad = '';
} else {
    $estado_maniobra = $_POST['estado_maniobra'];
    $unidad = $_POST['unidad'];
}

$SqlSelect = "SELECT * FROM maniobra
inner join flota on flota.vehicle_id = maniobra.vehicle_id
inner join operadores on operadores.id = maniobra.operador_id
where estado_maniobra = '$estado_maniobra' 
and maniobra.vehicle_id like '%$unidad%'";
$resultado = $cn->query($SqlSelect);

$correos = [];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row;
    }
}

echo json_encode($correos);
