<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$placas = $_POST['placas'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

// Usar declaraciones preparadas para evitar inyección SQL
$stmt = $cn->prepare("
SELECT 
    r.id_viaje, 
    v.store_id,
    v.referencia,
    v.placas,
    v.employee_id,
    v.route_id,
    e.name,
    MIN(CASE WHEN r.id_estatus = 1 THEN r.fecha_envio END) AS inicio_viaje, 
    MIN(CASE WHEN r.id_estatus = 3 THEN r.fecha_envio END) AS llegada_planta, 
    MIN(CASE WHEN r.id_estatus = 8 THEN r.fecha_envio END) AS salida_planta, 
    MIN(CASE WHEN r.id_estatus = 103 THEN r.fecha_envio END) AS fin_viaje 
FROM reportes_estatus_viajes r
INNER JOIN viajes v ON v.id = r.id_viaje
INNER JOIN empleados e ON v.employee_id = e.id
WHERE r.id_estatus IN (1, 3, 8, 103) 
AND v.placas = ?
AND DATE(v.fecha_inicio) BETWEEN ? AND ?
GROUP BY r.id_viaje 
ORDER BY v.fecha_inicio DESC;
");
$stmt->bind_param('sss', $placas, $fecha_inicio, $fecha_fin);
$stmt->execute();
$resultSel = $stmt->get_result();

function llamar_procedimiento($cn, $placas, $inicio, $fin)
{
    // Usar declaraciones preparadas para evitar inyección SQL
    $stmt = $cn->prepare("
    SELECT
        placas,
        SUM(duracion_minutos) AS duracion_total_minutos
    FROM (
        SELECT
            placas,
            MIN(fecha_hora) AS inicio_detencion,
            MAX(fecha_hora) AS fin_detencion,
            TIMESTAMPDIFF(MINUTE, MIN(fecha_hora), MAX(fecha_hora)) AS duracion_minutos
        FROM (
            SELECT
                placas,
                fecha_hora,
                velocidad,
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
    GROUP BY placas;
    ");
    $stmt->bind_param('sss', $placas, $inicio, $fin);
    $stmt->execute();
    return $stmt->get_result();
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Sucursal</th>
            <th scope="col">Unidad</th>
            <th scope="col">Placas</th>
            <th scope="col">Operador</th>
            <th scope="col">Ruta</th>
            <th scope="col">Inicio de viaje</th>
            <th scope="col">Llegada a planta</th>
            <th scope="col">Salida de planta</th>
            <th scope="col">Fin de viaje</th>
            <th scope="col">Detenido Inicio -> Llegada</th>
            <th scope="col">Detenido Llegada -> Salida</th>
            <th scope="col">Detenido Salida -> Fin</th>
            <th scope="col">Detenido Salida -> Total</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultSel->fetch_assoc()) { ?>
            <tr onclick="abrir_viaje()">
                <td><?php echo htmlspecialchars($row['store_id']); ?></td>
                <td><?php echo htmlspecialchars($row['referencia']); ?></td>
                <td><?php echo htmlspecialchars($row['placas']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['route_id']); ?></td>
                <td><?php echo htmlspecialchars($row['inicio_viaje']); ?></td>
                <td><?php echo htmlspecialchars($row['llegada_planta']); ?></td>
                <td><?php echo htmlspecialchars($row['salida_planta']); ?></td>
                <td><?php echo htmlspecialchars($row['fin_viaje']); ?></td>
                <td>
                    <?php
                    $resultadosInicioLlegada = llamar_procedimiento($cn, $row['placas'], $row['inicio_viaje'], $row['llegada_planta']);
                    $detenidoInicioLlegada = $resultadosInicioLlegada->fetch_assoc()['duracion_total_minutos'] ?? 0;
                    echo htmlspecialchars($detenidoInicioLlegada);
                    ?>
                </td>
                <td>
                    <?php
                    $resultadosLlegadaSalida = llamar_procedimiento($cn, $row['placas'], $row['llegada_planta'], $row['salida_planta']);
                    $detenidoLlegadaSalida = $resultadosLlegadaSalida->fetch_assoc()['duracion_total_minutos'] ?? 0;
                    echo htmlspecialchars($detenidoLlegadaSalida);
                    ?>
                </td>
                <td>
                    <?php
                    $resultadosSalidaFin = llamar_procedimiento($cn, $row['placas'], $row['salida_planta'], $row['fin_viaje']);
                    $detenidoSalidaFin = $resultadosSalidaFin->fetch_assoc()['duracion_total_minutos'] ?? 0;
                    echo htmlspecialchars($detenidoSalidaFin);
                    ?>
                </td>
                <td>
                    <?php
                    $totalDetencion = $detenidoInicioLlegada + $detenidoLlegadaSalida + $detenidoSalidaFin;
                    echo htmlspecialchars($totalDetencion);
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>