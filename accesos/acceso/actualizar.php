<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

session_start();
$id_usuario = $_SESSION['userID'];
$fechaHoraActual = date("Y-m-d H:i:s");

header("Content-Type: application/json");
$requestBody = file_get_contents("php://input");

$data = json_decode($requestBody, true);

if ($data === null) {
    http_response_code(400);
    echo json_encode(["error" => "Datos inválidos."]);
    exit;
}

$id_acceso = $data['id_acceso'];
$id_empresa = $data['id_empresa'];
$tipo_movimiento = $data['tipo_movimiento'];
$tipo_identificacion = $data['tipo_identificacion'];
$id_empresa = $data['id_empresa'];
$id_empresa_visitada = $data['id_empresa_visitada'];
$fecha_entrada = date('Y-m-d H:i:s', strtotime($data['fecha_entrada']));
$fecha_salida = date('Y-m-d H:i:s', strtotime($data['fecha_salida']));
$areas = $data['areas'];
$motivo = $data['motivo'];
$notas = $data['notas'];

$visitantesAñadidos = $data['visitantesAñadidos'] ?? [];
$visitantesEliminados = $data['visitantesEliminados'] ?? [];

$vehiculosAñadidos = $data['vehiculosAñadidos'] ?? [];
$vehiculosEliminados = $data['vehiculosEliminados'] ?? [];

$sql = "UPDATE accesos
set 
id_empresa = $id_empresa, 
id_empresa_visitada = $id_empresa_visitada, 
tipo_movimiento = '$tipo_movimiento', 
fecha_entrada = '$fecha_entrada', 
fecha_salida = '$fecha_salida', 
tipo_identificacion = '$tipo_identificacion', 
areas = '$areas', 
motivo = '$motivo',
notas= '$notas'
where id_acceso = $id_acceso";
if ($cn->query($sql)) {

    foreach ($visitantesAñadidos as $visitante) {
        $id_visitante = $visitante['value'];
        $sql = "INSERT INTO acceso_visitante VALUES(NULL,$id_acceso,$id_visitante)";
        $cn->query($sql);
    }

    foreach ($visitantesEliminados as $visitante) {
        $id_visitante = $visitante['value'];
        $sql = "DELETE FROM acceso_visitante where id_visitante = $id_visitante and id_acceso = $id_acceso";
        $cn->query($sql);
    }

    foreach ($vehiculosAñadidos as $vehiculo) {
        $id_vehiculo = $vehiculo['value'];
        $sql = "INSERT INTO acceso_vehicular VALUES(NULL,$id_acceso,$id_vehiculo)";
        $cn->query($sql);
    }

    foreach ($vehiculosEliminados as $vehiculo) {
        $id_vehiculo = $vehiculo['value'];
        $sql = "DELETE FROM acceso_vehicular where id_vehiculo = $id_vehiculo and id_acceso = $id_acceso";
        $cn->query($sql);
    }

    $respuesta = array('status' => 1, 'id_insertado' => $id_acceso);
    echo json_encode($respuesta);
}
