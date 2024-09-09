<?php
function updateFlotaEstado($cn, $id_maniobra, $nuevo_estado)
{
    if (empty($nuevo_estado) || !is_numeric($id_maniobra)) {
        throw new Exception("Estado inválido o ID de maniobra no numérico.");
    }

    $nuevo_estado = $cn->real_escape_string($nuevo_estado);
    $id_maniobra = (int) $id_maniobra;

    $sqlEstado = "UPDATE flota
        SET estado = '$nuevo_estado'
        WHERE vehicle_id IN (
            SELECT vehicle_id FROM maniobra WHERE id_maniobra = $id_maniobra
            UNION
            SELECT trailer1_id FROM maniobra WHERE id_maniobra = $id_maniobra
            UNION
            SELECT trailer2_id FROM maniobra WHERE id_maniobra = $id_maniobra
            UNION
            SELECT dolly_id FROM maniobra WHERE id_maniobra = $id_maniobra
            UNION
            SELECT motogenerador_1 FROM maniobra WHERE id_maniobra = $id_maniobra
            UNION
            SELECT motogenerador_2 FROM maniobra WHERE id_maniobra = $id_maniobra
        )";

    $resultado = $cn->query($sqlEstado);
    if (!$resultado || $cn->affected_rows <= 0) {
        throw new Exception("No se actualizaron registros en la tabla flota.");
    }

    return true;
}
