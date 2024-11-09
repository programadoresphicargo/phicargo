<?php
require_once('../../mysql/conexion.php');

$data = json_decode(file_get_contents('php://input'), true);
session_start();
$id_usuario = $_SESSION['userID'] ?? null;
date_default_timezone_set('America/Mexico_City');
$fechaHoraMexico = date('Y-m-d H:i:s');
$cn = conectar();

$id_empresa = $data['id_empresa'] ?? null;
$nombre_visitante = $data['nombre_visitante'] ?? null;

if (is_null($id_empresa) || is_null($nombre_visitante)) {
    echo json_encode(array('success' => false, 'mensaje' => 'Datos incompletos: id_empresa o nombre_visitante no proporcionados.'));
    exit;
}

$sqlSelect = "SELECT * FROM visitantes WHERE nombre_visitante LIKE '%$nombre_visitante%'";
$resultado = $cn->query($sqlSelect);

if ($resultado === false) {
    echo json_encode(array('success' => false, 'mensaje' => 'Error en la consulta: ' . $cn->error));
    exit;
}

if ($resultado->num_rows <= 0) {
    $sql = "INSERT INTO visitantes (id_empresa, nombre_visitante, id_usuario, fecha_hora, estado_visitante) 
                VALUES ($id_empresa, '$nombre_visitante', $id_usuario, '$fechaHoraMexico', 'activo')";

    if ($cn->query($sql)) {
        $id_visitante = $cn->insert_id;
        $response = array(
            'success' => true,
            'mensaje' => 'Visitante agregado exitosamente.',
            'id_visitante' => $id_visitante
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('success' => false, 'mensaje' => 'Error al agregar el visitante: ' . $cn->error));
    }
} else {
    echo json_encode(array('success' => false, 'mensaje' => 'El visitante ya existe en la base de datos.'));
}

$cn->close();
