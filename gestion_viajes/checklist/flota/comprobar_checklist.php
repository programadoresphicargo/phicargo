<?php
require_once('../../../mysql/conexion.php');

$id_viaje = $_POST['id_viaje'];
$id_flota = $_POST['id_flota'];
$tipo_checklist = $_POST['tipo_checklist'];

$cn = conectar();
if ($tipo_checklist == 'salida') {
    $sql = "SELECT * FROM checklist_flota where id_viaje = $id_viaje and id_flota = $id_flota";
    $resultado = $cn->query($sql);
    if ($resultado !== false && $resultado->num_rows > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else  if ($tipo_checklist == 'reingreso') {
    $sqlSelect = "SELECT * FROM elementos_checklist 
    inner join revisiones_elementos_flota on revisiones_elementos_flota.elemento_id = elementos_checklist.id_elemento 
    inner join checklist_flota on checklist_flota.id = revisiones_elementos_flota.checklist_id 
    where id_viaje = $id_viaje and id_flota = $id_flota limit 1";
    $resultado = $cn->query($sqlSelect);
    $row = $resultado->fetch_assoc();
    if ($row['estado_entrada'] != null) {
        echo 1;
    } else {
        echo 0;
    }
}
