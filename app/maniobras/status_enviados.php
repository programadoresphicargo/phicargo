<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];
$userData = array();

$sqlSelect = "SELECT id_sm, id_cp, id_ubicacion_operador, status.id_status, fecha_envio, status_maniobras.comentarios, latitud, longitud, calle, localidad, sublocalidad, codigo_postal, status, status_maniobras.fecha_envio, nombre, status_maniobras.tipo FROM status_maniobras inner join ubicaciones_maniobras on status_maniobras.id_ubicacion_operador = ubicaciones_maniobras.id_ubicacion inner join status on status.id_status = status_maniobras.id_status left join evidencias on evidencias.id_evidencia = status_maniobras.id_evidencia where id_ubicacion_operador IS NOT NULL and id_cp = $id_cp and status_maniobras.tipo = '$tipo'";
$result = $cn->query($sqlSelect);
while ($row = $result->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);
