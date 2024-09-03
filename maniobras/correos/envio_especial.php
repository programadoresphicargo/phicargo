<?php
require_once('../../mysql/conexion.php');
require_once('metodos.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$cn = conectar();
$SqlSelect = "SELECT * FROM maniobra where estado_maniobra = 'activa'";
$resultado = $cn->query($SqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $ultimo_envio = $row['ultimo_envio'];
    if ((minutos_transcurridos(date("$ultimo_envio"), date($hora)) > 1)) {
        $rel = obtener_ubicacion($row['vehicle_id']);
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

            preg_match('/\((.*?)\)/', $referencia, $matches);

            if (isset($matches[1])) {
                $textoEnParentesis = $matches[1];
                if ($velocidad != 0) {
                    $id_status = 80;
                } else {
                    $id_status = 81;
                }
                $sqlManiobra = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = 'Retiro' and status = 'Activo'";
                $resultadoManiobra = $cn->query($sqlManiobra);
                $rowManiobra = $resultadoManiobra->fetch_assoc();
                $id_cp_maniobra = $rowManiobra['id'];
                $sqlSelectComent = "SELECT comentarios, fecha_envio from status_maniobras where id_maniobra = $id_cp_maniobra and comentarios like '%$textoEnParentesis%' order by fecha_envio desc limit 1";
                $resultadoComent = $cn->query($sqlSelectComent);
                if ($resultadoComent->num_rows > 0) {
                    $rowHora = $resultadoComent->fetch_assoc();
                    $fecha_envio = $rowHora['fecha_envio'];
                    if ((minutos_transcurridos(date("$fecha_envio"), date($hora)) > 30)) {
                        echo 'GUARDANDO UBICACION NUEVA' . '<br>';
                        enviar_correo($row['id_cp'], 'Retiro', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, null, $id_status);
                        guardar_base_datos($row['id_cp'], 'Retiro', $id_ubicacion, 8, $id_status, $hora, $textoEnParentesis);
                    } else {
                        echo "No han pasado 30 minutos desde el último registro de la ubicación '$textoEnParentesis'." . '<br>';
                    }
                } else {
                    echo 'GUARDANDO NUEVA UBICACION' . '<br>';
                    enviar_correo($row['id_cp'], 'Retiro', $contenedor, $latitud, $longitud, $referencia, $calle, $fecha_hora, $placas, null, $id_status);
                    guardar_base_datos($row['id_cp'], 'Retiro', $id_ubicacion, 8, $id_status, $hora, $textoEnParentesis);
                }
            } else {
                echo "No se encontró texto entre paréntesis." . '<br>';
            }
        }
    } else {
        echo $row['id_cp'] . ' NO HAN PASADO 1 minuto' . '<br>';
    }
}
