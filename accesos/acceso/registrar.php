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
$motivo = $data['motivo'];
$notas = $data['notas'];
$areas = $data['areas'];

$visitantes_seleccionados = $data['visitantes_seleccionados'] ?? [];
$vehiculos_seleccionados = $data['vehiculos_seleccionados'] ?? [];

$sql = "INSERT INTO accesos VALUES(
    NULL,
    $id_empresa,
    '$tipo_movimiento',
    '$fecha_entrada',
    '$fecha_salida',
    '$tipo_identificacion',
    '$areas',
    '$motivo',$id_usuario,
    '$fechaHoraActual',
    'espera',
    null,
    null,
    null,
    null,
    '$notas',
    $id_empresa_visitada)";

if ($cn->query($sql)) {
    $id_acceso = $cn->insert_id;

    foreach ($visitantes_seleccionados as $visitante) {
        $id_visitante = $visitante['value'];
        $sql = "INSERT INTO acceso_visitante VALUES(NULL,$id_acceso,$id_visitante)";
        $cn->query($sql);
    }

    foreach ($vehiculos_seleccionados as $vehiculo) {
        $id_vehiculo = $vehiculo['value'];
        $sql = "INSERT INTO acceso_vehicular VALUES(NULL,$id_acceso,$id_vehiculo)";
        $cn->query($sql);
    }

    $respuesta = array('status' => 1, 'id_insertado' => $id_acceso);
    echo json_encode($respuesta);
}
