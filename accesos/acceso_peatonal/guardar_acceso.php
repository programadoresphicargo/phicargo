<?php
require_once('../../mysql/conexion.php');

$listaJSON = $_POST['lugares'];
$opcionesSeleccionadas = json_encode($listaJSON, true);

$datos = $_POST['datos'];
parse_str($datos, $datosF);

$id_acceso = $datosF['id_acceso'];
$tipo_mov = $datosF['tipo_mov'];
$fecha_entrada = $datosF['fecha_entrada'];
$empresa = $datosF['empresa'];
$tipo_identificacion = $datosF['tipo_identificacion'];
$motivo = $datosF['motivo'];

$cn = conectar();
$sql = "UPDATE acceso_peatonal set fecha_entrada = '$fecha_entrada', tipo_identificacion = '$tipo_identificacion', id_empresa = $empresa, areas = $opcionesSeleccionadas, motivo = '$motivo', tipo_mov = '$tipo_mov' where id_acceso = $id_acceso";
if ($cn->query($sql)) {
    $respuesta = array('status' => 1);
    echo json_encode($respuesta);
} else {
    $respuesta = array('status' => 0, 'error' => $cn->error);
    echo json_encode($respuesta);
}
