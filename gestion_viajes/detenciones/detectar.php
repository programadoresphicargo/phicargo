<?php
if (ob_get_level() == 0) ob_start();

echo "Inicio del proceso...\n";

require_once('../../mysql/conexion.php');

$logFile = 'execution_times.txt';
$startTime = microtime(true);

$cn = conectar();

function obtenerDetencionesActivas($cn)
{
    $sql = "SELECT * FROM registro_detenciones WHERE fin_detencion IS NULL";
    $stmt = $cn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function abrirRegistroDetencion($cn, $id_viaje, $placas, $estado, $inicio_detencion, $id_ubicacion)
{
    $sql = "INSERT INTO registro_detenciones (id_viaje, placas, estado_viaje, inicio_detencion, id_ubicacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $cn->prepare($sql);
    $stmt->bind_param('isssi', $id_viaje, $placas, $estado, $inicio_detencion, $id_ubicacion);
    $stmt->execute();
    echo 'Se abrió detención para ' . $placas . '<br>';
}

function obtenerUltimaVelocidad($cn, $placas)
{
    $sql = "SELECT * FROM ubicaciones WHERE placas = ? ORDER BY fecha_hora DESC LIMIT 1";
    $stmt = $cn->prepare($sql);
    $stmt->bind_param('s', $placas);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function actualizarFinDetencion($cn, $placas, $fin_detencion)
{
    $sql = "UPDATE registro_detenciones SET fin_detencion = ? WHERE placas = ? AND fin_detencion IS NULL";
    $stmt = $cn->prepare($sql);
    $stmt->bind_param('ss', $fin_detencion, $placas);
    $stmt->execute();
}

function actualizarTodasLasDetencionesPendientes($cn)
{
    $sql = "SELECT rd.placas, v.estado, rd.fin_detencion 
            FROM registro_detenciones rd 
            INNER JOIN viajes v ON v.id = rd.id_viaje";
    $resultado = $cn->query($sql);
    $placas_pendientes = $resultado->fetch_all(MYSQLI_ASSOC);

    foreach ($placas_pendientes as $registro) {
        $placas = $registro['placas'];
        $estado = $registro['estado'];
        $fin_detencion = $registro['fin_detencion'];

        $ultima_velocidad = obtenerUltimaVelocidad($cn, $placas);
        if ($ultima_velocidad) {
            $velocidad = $ultima_velocidad[0]['velocidad'];
            $fecha_hora = $ultima_velocidad[0]['fecha_hora'];

            if ($estado === 'finalizado' || ($fin_detencion === NULL && $velocidad > 0)) {
                actualizarFinDetencion($cn, $placas, $fecha_hora);
            }
        }
    }
}

function verificarYAbrirDetenciones($cn)
{
    $sql = "SELECT v.id, v.placas, v.estado, u.id AS id_ubicacion, u.fecha_hora 
            FROM viajes v 
            INNER JOIN (SELECT placas, MAX(fecha_hora) AS max_fecha_hora FROM ubicaciones GROUP BY placas) ultima_ubicacion 
            ON v.placas = ultima_ubicacion.placas 
            INNER JOIN ubicaciones u 
            ON u.placas = ultima_ubicacion.placas AND u.fecha_hora = ultima_ubicacion.max_fecha_hora 
            WHERE v.estado IN ('ruta', 'planta', 'retorno')";
    $resultado = $cn->query($sql);
    $camiones = $resultado->fetch_all(MYSQLI_ASSOC);

    foreach ($camiones as $camion) {
        $placas = $camion['placas'];
        $ultima_velocidad = obtenerUltimaVelocidad($cn, $placas);

        if ($ultima_velocidad) {
            $velocidad = $ultima_velocidad[0]['velocidad'];
            $fecha_hora = $ultima_velocidad[0]['fecha_hora'];

            echo $placas . ' - ' . $velocidad . ' - ' . $fecha_hora . '<br>';

            if ($velocidad <= 0) {
                $detenciones_activas = obtenerDetencionesActivas($cn);
                $hay_detencion_activa = false;

                foreach ($detenciones_activas as $detencion) {
                    if ($detencion['placas'] == $placas) {
                        $hay_detencion_activa = true;
                        break;
                    }
                }

                if (!$hay_detencion_activa) {
                    $tiempo_detencion = strtotime('now') - strtotime($fecha_hora);
                    if ($tiempo_detencion > 5 * 60) {
                        abrirRegistroDetencion($cn, $camion['id'], $placas, $camion['estado'], $fecha_hora, $camion['id_ubicacion']);
                    }
                }
            }
        }
    }

    actualizarTodasLasDetencionesPendientes($cn);
}

verificarYAbrirDetenciones($cn);

$endTime = microtime(true);
$elapsedTime = ($endTime - $startTime) / 60;
$formattedTime = number_format($elapsedTime, 2);
$message = date('Y-m-d H:i:s') . " - Tiempo de ejecución: " . $formattedTime . " minutos\n";
file_put_contents($logFile, $message, FILE_APPEND | LOCK_EX);

echo "Tiempo de ejecución registrado en el archivo de log.\n";
echo "Proceso completado.\n";
flush();
