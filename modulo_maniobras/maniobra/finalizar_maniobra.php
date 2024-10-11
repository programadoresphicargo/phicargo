<?php
require_once('../codigos/cambiar_estados.php');
require_once('cambiar_estatus.php');

try {
    require_once('../../postgresql/conexion.php'); // Cambia a la conexión de PostgreSQL
    session_start();

    $pdo = conectarPostgresql();
    $fechaHora = date('Y-m-d H:i:s');

    if (!isset($_POST['id_maniobra']) && !isset($_GET['id_maniobra'])) {
        throw new Exception("ID de maniobra no proporcionado.");
    }

    $id_maniobra = isset($_POST['id_maniobra']) ? $_POST['id_maniobra'] : $_GET['id_maniobra'];
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['userID'];

    if (!is_numeric($id_maniobra) || !is_numeric($id_usuario)) {
        throw new Exception("ID de maniobra o usuario no válidos.");
    }

    $pdo->beginTransaction();
    $sql = "UPDATE maniobras SET 
            estado_maniobra = :estado, 
            usuario_finalizo = :id_usuario, 
            fecha_finalizada = :fecha_finalizada 
            WHERE id_maniobra = :id_maniobra";

    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $pdo->errorInfo()[2]);
    }

    $estado = 'finalizada';
    $stmt->execute([
        ':estado' => $estado,
        ':id_usuario' => $id_usuario,
        ':fecha_finalizada' => $fechaHora,
        ':id_maniobra' => $id_maniobra
    ]);

    if ($stmt->rowCount() > 0) {
        updateFlotaEstado($pdo, $id_maniobra, 'disponible');

        $sqlTM = "SELECT tipo_maniobra FROM maniobras where maniobras.id_maniobra = :id_maniobra";
        $stmtTM = $pdo->prepare($sqlTM);
        $stmtTM->execute([':id_maniobra' => $id_maniobra]);
        $rowsTM = $stmtTM->fetchAll(PDO::FETCH_ASSOC);
        $tipo_maniobra = $rowsTM[0]['tipo_maniobra'];

        if ($tipo_maniobra == 'retiro') {
            actualizar_estado_contenedor($id_maniobra, 'P');
        } else if ($tipo_maniobra == 'ingreso') {
            actualizar_estado_contenedor($id_maniobra, 'Ing');
        }

        $pdo->commit();
        echo json_encode(["success" => 1]);
        guardar_base_datos($id_maniobra, false, 256, $id_usuario, 'Finalizando maniobra', null);
    } else {
        throw new Exception("Error al actualizar la tabla maniobra.");
    }
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(["error" => $e->getMessage()]);
}

$pdo = null;
