<?php
require_once('../../mysql/conexion.php');

function obtenerRegistrosDetenciones()
{
    // Conectar a la base de datos
    $cn = conectar();

    // Definir la consulta SQL
    $sql = "SELECT 
            rd.*, 
            v.referencia AS referencia_viaje, 
            rd.estado_viaje AS estado_viaje, 
            o.*, 
            u.*, 
            ubi.*, 
            usu.*, 
            CASE
                WHEN rd.fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, NOW() - INTERVAL 6 HOUR)
                ELSE TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, rd.fin_detencion)
            END AS tiempo_transcurrido_minutos,
            (SELECT MAX(fecha_hora)
             FROM ubicaciones
             WHERE placas = u.placas
            ) AS ultima_fecha_hora_ubicacion
        FROM 
            registro_detenciones AS rd 
            LEFT JOIN viajes AS v ON v.id = rd.id_viaje
            LEFT JOIN operadores AS o ON o.id = v.employee_id 
            LEFT JOIN unidades AS u ON u.placas = v.placas 
            LEFT JOIN ubicaciones AS ubi ON ubi.id = rd.id_ubicacion
            LEFT JOIN usuarios AS usu ON usu.id_usuario = rd.usuario_atendio
        WHERE 
            rd.estado_viaje IN ('ruta', 'retorno')
            AND (
                CASE
                    WHEN rd.fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, NOW() - INTERVAL 6 HOUR)
                    ELSE TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, rd.fin_detencion)
                END > 15
            )
            AND (
                (SELECT MAX(fecha_hora)
                 FROM ubicaciones
                 WHERE placas = u.placas
                ) > (NOW() - INTERVAL 6 HOUR) - INTERVAL 15 MINUTE
                OR (SELECT MAX(fecha_hora)
                    FROM ubicaciones
                    WHERE placas = u.placas
                   ) IS NULL
            )
        ORDER BY 
            rd.inicio_detencion DESC";

    $result = mysqli_query($cn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $registros = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $registros[] = $row;
        }

        return $registros;
    } else {
        return array();
    }
}

function obtenerNumRegistrosDetenciones()
{
    $cn = conectar();

    $sql = "SELECT * FROM
    registro_detenciones WHERE estado_viaje IN ('ruta', 'retorno')
    AND atendida = 0
    AND ( CASE WHEN fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, inicio_detencion, NOW() - INTERVAL 6 HOUR)
    ELSE TIMESTAMPDIFF(MINUTE, inicio_detencion, fin_detencion)
    END > 15)";

    $result = mysqli_query($cn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $registros = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $registros[] = $row;
        }

        return $registros;
    } else {
        return array();
    }
}
