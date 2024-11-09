<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fechaHoraActual = date('Y-m-d H:i:s');
session_start();
$id_usuaio = $_SESSION['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['comentario'])) {

        $id_evento = $data['id_evento'];
        $comentario = $data['comentario'];
        $sql = "INSERT INTO comentarios_eventos VALUES(NULL, $id_evento, $id_usuaio, '$fechaHoraActual', '$comentario')";
        $cn->query($sql);

        echo json_encode([
            'status' => 'success',
            'message' => 'Comentario recibido con éxito',
            'comentario' => $comentario,
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'El campo comentario no fue enviado',
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método de solicitud no permitido',
    ]);
}
