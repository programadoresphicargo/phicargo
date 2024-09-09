<?php
require_once('../codigos/cambiar_estados.php');

try {
    require_once('../../mysql/conexion.php');
    session_start();

    $cn = conectar();
    $fechaHora = date('Y-m-d H:i:s');

    if (!isset($_POST['id_maniobra']) && !isset($_GET['id_maniobra'])) {
        throw new Exception("ID de maniobra no proporcionado.");
    }

    $id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['userID'];

    if (!is_numeric($id_maniobra) || !is_numeric($id_usuario)) {
        throw new Exception("ID de maniobra o usuario no válidos.");
    }

    $cn->begin_transaction();

    $sql = "UPDATE maniobra SET 
        estado_maniobra = ?, 
        usuario_activacion = ?, 
        fecha_activacion = ? 
        WHERE id_maniobra = ?";
    $stmt = $cn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $cn->error);
    }

    $estado = 'activa';
    $stmt->bind_param('sisi', $estado, $id_usuario, $fechaHora, $id_maniobra);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        updateFlotaEstado($cn, $id_maniobra, 'maniobra');
        $cn->commit();
        echo 1;
    } else {
        throw new Exception("Error al actualizar la tabla maniobra.");
    }
} catch (Exception $e) {
    $cn->rollback();
    echo $e->getMessage();
}

$cn->close();
