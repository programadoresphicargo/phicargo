<?php
require_once('../../mysql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$cn = conectar();
$SqlSelect = "SELECT * FROM maniobras where status = 'Activo'";
$resultado = $cn->query($SqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $ultimo_envio = $row['ultimo_envio'];
    if ((minutos_transcurridos(date("$ultimo_envio"), date($hora)) > 59)) {
        echo '--------------------------------------' . $row['id_cp'] . '<br>';
        echo '--------------------------------------' . $row['tipo'] . '<br>';
        if ($row['tipo'] == 'Retiro') {
            $rel = obtener_unidad($row['id_cp'], 'x_eco_retiro_id');
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

                echo $placas . '<br>';
                echo $latitud . '<br>';
                echo $longitud . '<br>';
                echo $referencia . '<br>';
                echo $calle . '<br>';
                echo $fecha_hora . '<br>';
                echo $contenedor . '<br>';

                if ($velocidad != 0) {
                    $id_status = 80;
                } else {
                    $id_status = 81;
                }
                enviar_correo($row['id_cp'], 'Retiro', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, null, $id_status);
                guardar_base_datos($row['id_cp'], 'Retiro', $id_ubicacion, 8, $id_status, $hora, null);
            }
        } else if ($row['tipo'] == 'Ingreso') {
            $rel = obtener_unidad($row['id_cp'], 'x_eco_ingreso_id');
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

                echo $placas . '<br>';
                echo $latitud . '<br>';
                echo $longitud . '<br>';
                echo $referencia . '<br>';
                echo $calle . '<br>';
                echo $fecha_hora . '<br>';
                echo $contenedor . '<br>';

                if ($velocidad != 0) {
                    $id_status = 80;
                } else {
                    $id_status = 81;
                }

                enviar_correo($row['id_cp'], 'Ingreso', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, null, $id_status);
                guardar_base_datos($row['id_cp'], 'Ingreso', $id_ubicacion, 8, $id_status, $hora, null);
            }
        }
    } else {
        echo $row['id_cp'] . ' NO HAN PASADO 1 HORA';
    }
}
