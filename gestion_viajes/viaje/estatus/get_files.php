<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();

$id_reporte = $_POST['id_reporte'];
$sql = "SELECT  *  FROM archivos_adjuntos inner join reportes_estatus_viajes on reportes_estatus_viajes.id_reporte = archivos_adjuntos.id_reporte WHERE archivos_adjuntos.id_reporte = $id_reporte";
$result = $cn->query($sql);

$archivos = array();

while ($row = $result->fetch_assoc()) {
    $archivos[] = array(
        'name' => $row['nombre'],
        'url' => '../adjuntos_estatus/' . $row['id_viaje'] . '/' . $row['nombre'],
    );
}

echo json_encode($archivos);
