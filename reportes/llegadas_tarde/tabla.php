<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fecha_actual = date('Y-m-d H:i:s');
echo "Fecha y hora actual: " . $fecha_actual;

function obtenerDetenciones($placas, $fechaInicio, $fechaFin, $conexion)
{
    // Preparar la consulta SQL con placeholders
    $sql = "
    SELECT
    placas,
    SUM(duracion_minutos) AS total_duracion_minutos
FROM (
    SELECT
        placas,
        MIN(fecha_hora) AS inicio_detencion,
        MAX(fecha_hora) AS fin_detencion,
        TIMESTAMPDIFF(MINUTE, MIN(fecha_hora), MAX(fecha_hora)) AS duracion_minutos,
        latitud,
        longitud
    FROM (
        SELECT
            placas,
            fecha_hora,
            velocidad,
            latitud,
            longitud,
            CASE
                WHEN velocidad < 1 THEN @grp := @grp
                ELSE @grp := @grp + 1
            END AS grupo_detencion
        FROM ubicaciones
        CROSS JOIN (SELECT @grp := 0) AS vars
            WHERE placas = ?
              AND fecha_hora BETWEEN ? AND ?
            ORDER BY fecha_hora
        ) AS detenciones
        WHERE velocidad < 1
        GROUP BY placas, grupo_detencion
    ) AS detenciones_con_duracion
    GROUP BY placas
    HAVING total_duracion_minutos > 0 ";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('sss', $placas, $fechaInicio, $fechaFin);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return 0;
        }

        if (is_null($row['total_duracion_minutos'])) {
            return 0;
        }

        return $row['total_duracion_minutos'];
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        return false;
    }
}

if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_fin'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $sql = "SELECT 
    v.id AS id_actual, 
    v.estado AS estado_actual, 
    v.referencia AS referencia_actual, 
    DATE_FORMAT(CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00'), '%Y-%m-%d %H:%i') AS fecha_planta_actual, 
    v.placas AS placas_actual, 
    u.unidad AS unidad_actual, 
    v.employee_id AS employee_id_actual, 
    o.nombre_operador AS nombre_operador_actual, 
    v.route_id AS route_id_actual,
    v.fecha_finalizado AS fecha_finalizado_actual,
    DATE_FORMAT(COALESCE(c.fecha_envio, ''), '%Y-%m-%d %H:%i') AS fecha_envio_actual, 
    DATE_FORMAT(COALESCE(c2.fecha_envio, ''), '%Y-%m-%d %H:%i') AS fecha_salida_planta, 
    TIMEDIFF(
        COALESCE(c.fecha_envio, CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00')), 
        CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00')
    ) AS tiempo_diferencia_actual, 
    DATE_FORMAT(CONVERT_TZ(v.x_inicio_programado, '+00:00', '-06:00'), '%Y-%m-%d %H:%i') AS fecha_programada_actual, 
    DATE_FORMAT(v.fecha_inicio, '%Y-%m-%d %H:%i') AS fecha_inicio_actual, 
    TIMEDIFF(v.fecha_inicio, CONVERT_TZ(v.x_inicio_programado, '+00:00', '-06:00')) AS tiempo_diferencia_2_actual,
    v_prev.id AS id_anterior,
    v_prev.referencia AS referencia_anterior,
    DATE_FORMAT(v_prev.fecha_finalizado, '%Y-%m-%d %H:%i') AS fecha_finalizado_anterior
FROM 
    viajes v 
LEFT JOIN 
    reportes_estatus_viajes c ON v.id = c.id_viaje AND c.id_estatus = 3
LEFT JOIN 
    reportes_estatus_viajes c2 ON v.id = c2.id_viaje AND c2.id_estatus = 8
LEFT JOIN 
    operadores o ON v.employee_id = o.id 
LEFT JOIN 
    unidades u ON v.placas = u.placas 
LEFT JOIN 
    viajes v_prev ON v.employee_id = v_prev.employee_id
    AND v_prev.fecha_finalizado < v.fecha_inicio
    AND v_prev.fecha_finalizado = (
        SELECT MAX(v1.fecha_finalizado)
        FROM viajes v1
        WHERE v1.employee_id = v.employee_id
          AND v1.fecha_finalizado < v.fecha_inicio
    )
WHERE 
    DATE(CONVERT_TZ(v.x_inicio_programado, '+00:00', '-06:00')) BETWEEN '$fecha_inicio' AND '$fecha_fin'
GROUP BY 
    v.id";
}

$resultado = $cn->query($sql);
?>

<table class="table" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Viaje anterior / Finalización</th>
            <th scope="col">Referencia viaje</th>
            <th scope="col">Estado viaje</th>
            <th scope="col">Nombre operador</th>
            <th scope="col">Unidad</th>
            <th scope="col">Ruta</th>
            <th scope="col">Inicio de ruta programado</th>
            <th scope="col">Inicio de ruta real</th>
            <th scope="col">Estado</th>
            <th scope="col">Diferencia tiempo</th>
            <th scope="col">Llegada a planta programada</th>
            <th scope="col">Llegada a planta reportada</th>
            <th scope="col">Estado</th>
            <th scope="col">Diferencia tiempo</th>
            <th scope="col">Minutos detenciones de patio a cliente</th>
            <th scope="col">Salida planta</th>
            <th scope="col">Detenido en planta</th>
            <th scope="col">Detenido de planta a patio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="abrir_detenciones('<?php echo $row['id_actual'] ?>','<?php echo $row['placas_actual'] ?>')">
                <td scope="col" class="small"><?php echo $row['referencia_anterior'] . ' - ' . $row['fecha_finalizado_anterior'] ?></td>
                <td scope="col" class="small"><?php echo $row['referencia_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['estado_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['nombre_operador_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['unidad_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['route_id_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['fecha_programada_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['fecha_inicio_actual'] ?></td>
                <td scope="col" class="small">

                    <?php if (($row['fecha_inicio_actual'] == NULL) && ($row['fecha_programada_actual'] < $fecha_actual)) { ?>
                        <span class="badge bg-warning">Inicio de ruta excedido</span>
                    <?php } else if ($row['fecha_inicio_actual'] > $row['fecha_programada_actual']) { ?>
                        <span class="badge bg-danger">Salio tarde</span>
                    <?php } else if ($row['fecha_inicio_actual'] <  $row['fecha_programada_actual']) { ?>
                        <span class="badge bg-success">Salio a tiempo</span>
                    <?php } ?>

                </td>
                <td scope="col" class="small"><?php echo $row['tiempo_diferencia_2_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['fecha_planta_actual'] ?></td>
                <td scope="col" class="small"><?php echo $row['fecha_envio_actual'] ?></td>
                <td scope="col" class="small">
                    <?php if ($row['estado_actual'] != 'Disponible') { ?>
                        <?php if (($row['fecha_envio_actual'] != NULL) && ($row['fecha_envio_actual'] < $fecha_actual)) { ?>
                            <span class="badge bg-warning">Ya va tarde</span>
                        <?php } else if ($row['fecha_envio_actual'] > $row['fecha_planta_actual']) { ?>
                            <span class="badge bg-danger">Llego tarde</span>
                        <?php } else if ($row['fecha_envio_actual'] <  $row['fecha_planta_actual']) { ?>
                            <span class="badge bg-success">Llego a tiempo</span>
                        <?php } ?>
                    <?php } ?>
                </td>
                <td scope="col" class="small"><?php echo $row['tiempo_diferencia_actual'] ?></td>
                <?php
                $placas = $row['placas_actual'];
                $inicio = $row['fecha_inicio_actual'];
                $fin = $row['fecha_envio_actual'];
                if ($inicio != NULL && $fin != NULL) { ?>
                    <td scope="col"><?php echo obtenerDetenciones($placas, $inicio, $fin, $cn) ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <td scope="col" class="small"><?php echo $row['fecha_salida_planta'] ?></td>
                <?php
                $placas = $row['placas_actual'];
                $inicio = $row['fecha_envio_actual'];
                $fin = $row['fecha_salida_planta'];
                if ($inicio != NULL && $fin != NULL) { ?>
                    <td scope="col"><?php echo obtenerDetenciones($placas, $inicio, $fin, $cn) ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                <?php
                $placas = $row['placas_actual'];
                $inicio = $row['fecha_salida_planta'];
                $fin = $row['fecha_finalizado_actual'];
                if ($inicio != NULL && $fin != NULL) { ?>
                    <td scope="col"><?php echo obtenerDetenciones($placas, $inicio, $fin, $cn) ?></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function abrir_detenciones(id_viaje, placas) {
        $("#modal_detenciones").modal('show');
        $.ajax({
            url: '../../gestion_viajes/alertas/canvas/detenciones_tiempos.php',
            type: 'POST',
            data: {
                id_viaje: id_viaje,
                placas: placas
            },
            success: function(respuesta) {
                $('#detenciones').html(respuesta);
            },
            error: function() {
                noty.error('Error');
            }
        });
    }
</script>