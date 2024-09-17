<?php
function updateFlotaEstado($cn, $id_maniobra, $nuevo_estado)
{
    if (empty($nuevo_estado) || !is_numeric($id_maniobra)) {
        throw new Exception("Estado inválido o ID de maniobra no numérico.");
    }

    // Asegúrate de que el ID sea un número entero
    $id_maniobra = (int) $id_maniobra;

    // Consulta SQL con placeholders
    $sqlEstado = "UPDATE fleet_vehicle
        SET x_status = :nuevo_estado
        WHERE id IN (
            SELECT vehicle_id FROM maniobras WHERE id_maniobra = :id_maniobra
            UNION
            SELECT trailer1_id FROM maniobras WHERE id_maniobra = :id_maniobra
            UNION
            SELECT trailer2_id FROM maniobras WHERE id_maniobra = :id_maniobra
            UNION
            SELECT dolly_id FROM maniobras WHERE id_maniobra = :id_maniobra
            UNION
            SELECT motogenerador_1 FROM maniobras WHERE id_maniobra = :id_maniobra
            UNION
            SELECT motogenerador_2 FROM maniobras WHERE id_maniobra = :id_maniobra
        )";

    // Preparar la consulta con PDO
    $stmt = $cn->prepare($sqlEstado);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $cn->errorInfo()[2]);
    }

    // Ejecutar la consulta con los parámetros
    $stmt->execute([
        ':nuevo_estado' => $nuevo_estado,
        ':id_maniobra' => $id_maniobra
    ]);

    // Verificar si alguna fila fue afectada
    if ($stmt->rowCount() <= 0) {
        throw new Exception("No se actualizaron registros en la tabla flota.");
    }

    return true;
}
