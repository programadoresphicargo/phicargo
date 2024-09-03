<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_cp = $_GET['id_cp'];

$sql = "SELECT 
maniobra.id_maniobra,
tipo_maniobra,
inicio_programado,
terminal,
name,
nombre_operador,
estado_maniobra
FROM maniobra
left join operadores on operadores.id = maniobra.operador_id
left join flota on flota.vehicle_id = maniobra.vehicle_id
left join maniobra_contenedores on maniobra_contenedores.id_maniobra = maniobra.id_maniobra
where maniobra_contenedores.id_cp = $id_cp
order by maniobra.id_maniobra desc";

$result = mysqli_query($cn, $sql);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($cn));
}

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_free_result($result);
mysqli_close($cn);

header('Content-Type: application/json');
echo json_encode($data);
