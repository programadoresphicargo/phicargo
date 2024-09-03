<?php
require_once('../../mysql/conexion.php');

$listaJSON = $_POST['lugares'];
$opcionesSeleccionadas = json_encode($listaJSON, true);

$datos = $_POST['datos'];
parse_str($datos, $datosF);

$id_acceso = $datosF['id_acceso'];
$fecha_entrada = $datosF['fecha_entrada'];
$id_empresa = $datosF['id_empresa'];
$tipo_identificacion = $datosF['tipo_identificacion'];
$motivo = $datosF['motivo'];
$contenedor1 = $datosF['contenedor1'];
$contenedor2 = $datosF['contenedor2'];
$placas = $datosF['placas'];
$tipo_transporte = $datosF['tipo_transporte'];
$sellos = $datosF['sellos'];
$carga_descarga = $datosF['carga_descarga'];
$tipo_mov = $datosF['tipo_mov'];

$cn = conectar();
$sql = "UPDATE acceso_vehicular set 
fecha_entrada = '$fecha_entrada', 
tipo_identificacion = '$tipo_identificacion', 
id_empresa = $id_empresa, 
areas = $opcionesSeleccionadas, 
motivo = '$motivo',
placas = '$placas',
contenedor1 = '$contenedor1',
contenedor2 = '$contenedor2',
tipo_transporte = '$tipo_transporte',
sellos = '$sellos',
carga_descarga = '$carga_descarga',
tipo_mov = '$tipo_mov'
where id_acceso = $id_acceso";

if ($cn->query($sql)) {
    $respuesta = array('status' => 1);
    echo json_encode($respuesta);
} else {
    $respuesta = array('status' => 0, 'error' => $cn->error);
    echo json_encode($respuesta);
}
