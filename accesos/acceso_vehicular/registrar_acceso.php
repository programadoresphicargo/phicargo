<?php
require_once('../../mysql/conexion.php');

session_start();
$id_usuario = $_SESSION['userID'];
$listaJSON = $_POST['lugares'];
$opcionesSeleccionadas = json_encode($listaJSON, true);

$datos = $_POST['datos'];
parse_str($datos, $datosF);

$fechaHoraActual = date("Y-m-d H:i:s");
$nombre_operador = $datosF['nombre_operador'];
$fecha_entrada = $datosF['fecha_entrada'];
$placas = $datosF['placas'];
$tipo_transporte = $datosF['tipo_transporte'];
$contenedor1 = $datosF['contenedor1'];
$contenedor2 = $datosF['contenedor2'];
$carga_descarga = $datosF['carga_descarga'];
$id_empresa = $datosF['id_empresa'];
$sellos = $datosF['sellos'];
$tipo_identificacion = $datosF['tipo_identificacion'];
$motivo = $datosF['motivo'];
$tipo_mov = $datosF['tipo_mov'];

$cn = conectar();
$sql = "INSERT INTO acceso_vehicular VALUES(
    NULL,
    '$nombre_operador',
    '$placas',
    '$tipo_transporte',
    '$contenedor1',
    '$contenedor2',
    '$tipo_identificacion',
    '$carga_descarga',
    '$id_empresa',
    '$sellos',
    $opcionesSeleccionadas,
    '$motivo',
    $id_usuario,
    '$fechaHoraActual',
    '$fecha_entrada',
    null,
    null,
    'espera',
    null,
    null,
    '$tipo_mov')";

if ($cn->query($sql)) {
    $id_insertado = $cn->insert_id;
    $respuesta = array('status' => 1, 'id_insertado' => $id_insertado);
    echo json_encode($respuesta);
} else {
    $respuesta = array('status' => 0, 'error' => $cn->error);
    echo json_encode($respuesta);
}
