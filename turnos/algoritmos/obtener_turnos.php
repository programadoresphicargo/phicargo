<?php

function obtener_turnos($sucursal)
{
    require_once('../../mysql/conexion.php');
    $cn = conectar();
    $sqlSelect = "SELECT turno FROM turnos where cola = false and fecha_archivado IS NULL and sucursal = '$sucursal' order by turno desc";
    $resultSet = $cn->query($sqlSelect);
    $numero_rows = $resultSet->num_rows;
    return $numero_rows;
}

function reornedar_turnos($cn, $sucursal)
{
    $sqlSelect = "SELECT * FROM turnos where cola = false and fecha_archivado IS NULL and sucursal = '$sucursal' ORDER BY turno ASC";
    $resultSet = $cn->query($sqlSelect);

    $i = 0;
    while ($row = $resultSet->fetch_assoc()) {
        $i++;
        $turno = $i;
        $id_turno = $row['id_turno'];
        $sqlUpdate = "UPDATE turnos SET turno = $turno WHERE id_turno = $id_turno";
        if (!$cn->query($sqlUpdate)) {
            throw new Exception("Error al actualizar el turno: " . $cn->error);
        }
    }
}
