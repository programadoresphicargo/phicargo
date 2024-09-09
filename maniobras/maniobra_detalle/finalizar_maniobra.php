<?php
require_once('../codigos/cambiar_estados.php');

try {
    require_once('../../mysql/conexion.php');
    session_start();

    $cn = conectar();
    $fechaHora = date('Y-m-d H:i:s');

    // Verificar si id_maniobra está presente
    if (!isset($_POST['id_maniobra']) && !isset($_GET['id_maniobra'])) {
        throw new Exception("ID de maniobra no proporcionado.");
    }

    // Obtener id_maniobra y id_usuario
    $id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['userID'];

    // Validar que sean numéricos
    if (!is_numeric($id_maniobra) || !is_numeric($id_usuario)) {
        throw new Exception("ID de maniobra o usuario no válidos.");
    }

    // Iniciar transacción
    $cn->begin_transaction();

    // Consulta SQL para actualizar la maniobra
    $sql = "UPDATE maniobra SET 
                estado_maniobra = 'finalizada',
                usuario_finalizo = $id_usuario,
                fecha_finalizada = '$fechaHora'
            WHERE id_maniobra = $id_maniobra";

    // Ejecutar la consulta sin prepared statements (ya has pasado los valores en la cadena)
    if ($cn->query($sql)) {
        // Si la consulta fue exitosa, actualizar la tabla flota
        updateFlotaEstado($cn, $id_maniobra, 'disponible');

        // Confirmar la transacción
        $cn->commit();
        echo 1;
    } else {
        // Si falla la actualización de maniobra
        throw new Exception("Error al actualizar la tabla maniobra.");
    }
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $cn->rollback();
    echo $e->getMessage();
}

// Cerrar la conexión
$cn->close();
