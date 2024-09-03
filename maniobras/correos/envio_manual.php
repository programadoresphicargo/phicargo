<?php

require_once('../../mysql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$cn = conectar();
echo $id_cp = $_POST['id_cp'];
echo $id_usuario = $_POST['id_usuario'];
echo $tipo = $_POST['tipo'];
echo $comentarios = $_POST['comentarios'];

if ($tipo == 'Retiro') {
    $rel = obtener_unidad($id_cp, 'x_eco_retiro_id');
    if (isset($rel)) {
        $id_ubicacion = $rel->id_ubicacion;
        $placas = $rel->placas;
        $latitud = $rel->latitud;
        $longitud = $rel->longitud;
        $referencia = $rel->referencia;
        $calle = $rel->calle;
        $fecha_hora = $rel->fecha_hora;
        $velocidad = $rel->velocidad;
        $contenedor = $rel->contenedor;

        if (!isset($_POST['status_ejecutivo'])) {
            if ($velocidad != 0) {
                $id_status = 26;
            } else {
                $id_status = 27;
            }
        } else {
            $id_status = $_POST['status_ejecutivo'];
        }
        enviar_correo($id_cp, 'Retiro', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, $comentarios, $id_status);
        guardar_base_datos($id_cp, 'Retiro', $id_ubicacion, $id_usuario, $id_status, $hora, $comentarios);
    }
} else if ($tipo == 'Ingreso') {
    $rel = obtener_unidad($id_cp, 'x_eco_ingreso_id');
    if (isset($rel)) {
        $id_ubicacion = $rel->id_ubicacion;
        $placas = $rel->placas;
        $latitud = $rel->latitud;
        $longitud = $rel->longitud;
        $referencia = $rel->referencia;
        $calle = $rel->calle;
        $fecha_hora = $rel->fecha_hora;
        $contenedor = $rel->contenedor;

        if (!isset($_POST['status_ejecutivo'])) {
            if ($velocidad != 0) {
                $id_status = 26;
            } else {
                $id_status = 27;
            }
        } else {
            $id_status = $_POST['status_ejecutivo'];
        }

        enviar_correo($id_cp, 'Ingreso', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, $comentarios, $id_status);
        guardar_base_datos($id_cp, 'Ingreso', $id_ubicacion, $id_usuario, $id_status, $hora, $comentarios);
    }
}
