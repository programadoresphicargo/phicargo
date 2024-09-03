<?php
require_once('../../../mysql/conexion.php');
require_once('../../../tiempo/tiempo.php');

function obtenerDetenciones($placa, $inicio, $fin)
{
    if ($fin == null) {
        $fin = date('Y-m-d H:i:s');
    }

    $cn = conectar();
    // Consulta SQL
    $sql = "
    SELECT
    placas,
    inicio_detencion,
    fin_detencion,
    duracion_minutos,
    latitud,
    longitud
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
HAVING duracion_minutos > 0;
";

    // Preparar y ejecutar la consulta
    $stmt = $cn->prepare($sql);
    $stmt->bind_param('sss', $placa, $inicio, $fin);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Generar la tabla HTML
    echo "<table class='table table-sm table-hover'>
            <tr>
                <th>Placas</th>
                <th>Inicio Detención</th>
                <th>Fin Detención</th>
                <th>Duración (minutos)</th>
                <th>Coordenadas</th>
            </tr>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['placas']}</td>
                <td>{$fila['inicio_detencion']}</td>
                <td>{$fila['fin_detencion']}</td>
                <td>{$fila['duracion_minutos']}</td>
                <td><a class='link link-danger' href='https://www.google.com/maps?q={$fila['latitud']},{$fila['longitud']}&15z' target='_blank'><span class='d-block fs-5 text-dark text-truncate'><span class='text-muted'>{$fila['latitud']},{$fila['longitud']}</span></span></a></td>
                </tr>";
    }

    echo "</table>";
}
