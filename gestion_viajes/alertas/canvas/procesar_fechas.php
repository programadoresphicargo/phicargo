<?php

function procesarFechas(&$inicioViajeFecha, &$llegadaPlantaFecha, &$salidaPlantaFecha, &$finViajeFecha, $result)
{
    while ($row = $result->fetch_assoc()) {
        $id_estatus = $row['id_estatus'];
        $fechaHora = $row['fecha_envio'];

        if ($id_estatus == 1 && (!$inicioViajeFecha || $fechaHora < $inicioViajeFecha)) {
            $inicioViajeFecha = $fechaHora;
        } else if ((($id_estatus == 3 || $id_estatus == 4)) && (!$llegadaPlantaFecha || $fechaHora < $llegadaPlantaFecha)) {
            $llegadaPlantaFecha = $fechaHora;
        } else if ($id_estatus == 8 && (!$salidaPlantaFecha || $fechaHora < $salidaPlantaFecha)) {
            $salidaPlantaFecha = $fechaHora;
        } else if (($id_estatus == 103) && (!$finViajeFecha || $fechaHora < $finViajeFecha)) {
            $finViajeFecha = $fechaHora;
        }
    }
}
