<?php
require_once('../../../mysql/conexion.php');

$id_viaje = $_POST['id_viaje'];
$id_flota = $_POST['id_flota'];
$tipo_flota = $_POST['tipo_flota'];

$cn = conectar();

$sql = "SELECT * FROM checklist_flota where id_viaje = $id_viaje and id_flota =$id_flota";
$resultado = $cn->query($sql);
if ($resultado->num_rows <= 0) {
    $sqlSelect = "SELECT * FROM elementos_checklist where tipo = '$tipo_flota'";
    $resultSet = $cn->query($sqlSelect);
} else {
    $sqlSelect = "SELECT * FROM elementos_checklist 
    inner join revisiones_elementos_flota on revisiones_elementos_flota.elemento_id = elementos_checklist.id_elemento 
    inner join checklist_flota on checklist_flota.id = revisiones_elementos_flota.checklist_id 
    where id_viaje = $id_viaje and id_flota =$id_flota";
    $resultSet = $cn->query($sqlSelect);
}

while ($row = mysqli_fetch_array($resultSet)) $array[] = $row;
echo $json = json_encode($array);
