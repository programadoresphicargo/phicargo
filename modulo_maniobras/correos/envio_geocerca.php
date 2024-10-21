<?php
require_once('../../postgresql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

function minutos_transcurridos($fechaInicial, $fechaFinal)
{
    $fechaInicio = strtotime($fechaInicial);
    $fechaFin = strtotime($fechaFinal);
    $diferenciaMinutos = ($fechaFin - $fechaInicio) / 60;

    return $diferenciaMinutos;
}

$cn = conectarPostgresql();

$SqlSelect = "SELECT * FROM maniobras where estado_maniobra = 'activa'";
$resultado = $cn->query($SqlSelect);
while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {

    echo 'Maniobra ' . $row['id_maniobra'] . '<br>';
    $id_maniobra = $row['id_maniobra'];

    guardar_base_datos($id_maniobra, true, null, 8, null, null);
}
