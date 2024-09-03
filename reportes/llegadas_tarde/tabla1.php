<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fecha_actual = date('Y-m-d H:i:s');

$json = file_get_contents('php://input');
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];

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


$sql = "SELECT 
v.id AS id_actual, 
v.store_id AS sucursal,
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
$resultado = $cn->query($sql);
if ($resultado) {
    $data = array();
    while ($row = $resultado->fetch_assoc()) {

        $fecha_inicio_real = $row['fecha_inicio_actual'];
        $inicio_programado = $row['fecha_programada_actual'];
        $fecha_actual = date('Y-m-d H:i:s');

        if (empty($fecha_inicio_real)) {
            $row['estado_salida'] = (strtotime($fecha_actual) > strtotime($inicio_programado)) ? 'Ya va tarde' : 'Está en tiempo';
        } else {
            $row['estado_salida'] = (strtotime($fecha_inicio_real) > strtotime($inicio_programado)) ? 'Salió tarde' : 'Salió a tiempo';
        }

        $llegada_planta_real = $row['fecha_envio_actual'];
        $llegada_planta_programada = $row['fecha_planta_actual'];

        if (empty($llegada_planta_real)) {
            $row['estado_llegada_planta'] = (strtotime($fecha_actual) > strtotime($llegada_planta_programada)) ? 'Va a llegar tarde' : 'Está en tiempo';
        } else {
            $row['estado_llegada_planta'] = (strtotime($llegada_planta_real) > strtotime($llegada_planta_programada)) ? 'Llego tarde' : 'Llego a tiempo';
        }

        $placas = $row['placas_actual'];

        $inicio = $row['fecha_inicio_actual'];
        $fin = empty($row['fecha_envio_actual']) ? $fecha_actual : $row['fecha_envio_actual'];
        $row['detenciones_patio_planta'] = obtenerDetenciones($placas, $inicio, $fin, $cn);

        // Luego detenciones planta
        $inicio = $row['fecha_envio_actual'];
        $fin = empty($row['fecha_salida_planta']) ? $fecha_actual : $row['fecha_salida_planta'];
        $row['detenciones_planta'] = obtenerDetenciones($placas, $inicio, $fin, $cn);

        // Finalmente detenciones planta-patio
        $inicio = $row['fecha_salida_planta'];
        $fin = empty($row['fecha_finalizado_actual']) ? $fecha_actual : $row['fecha_finalizado_actual'];
        $row['detenciones_planta_patio'] = obtenerDetenciones($placas, $inicio, $fin, $cn);

        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "Error en la consulta SQL: " . $cn->error;
}
