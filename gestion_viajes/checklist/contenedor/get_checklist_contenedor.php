<?php
require_once('../../../mysql/conexion.php');

$id_viaje = $_POST['id_viaje'];
$id_cp = $_POST['id_cp'];
$tipo_checklist = $_POST['tipo_checklist'];

$cn = conectar();

$sql = "SELECT * FROM checklist_contenedor where id_viaje = $id_viaje and id_cp = $id_cp";
$resultado = $cn->query($sql);
if ($resultado->num_rows == 0) {
    $sqlSelect = "SELECT * FROM elementos_checklist where tipo = 'Contenedor'";
    $resultSet = $cn->query($sqlSelect);
} else {
    $sqlSelect = "SELECT * FROM elementos_checklist inner join revisiones_elementos_contenedor on revisiones_elementos_contenedor.elemento_id = elementos_checklist.id_elemento
    inner join checklist_contenedor on checklist_contenedor.checklist_id = revisiones_elementos_contenedor.checklist_id 
    where id_viaje = $id_viaje and id_cp =$id_cp";
    $resultSet = $cn->query($sqlSelect);
}
while ($row = mysqli_fetch_array($resultSet)) $array[] = $row;
echo $json = json_encode($array);
