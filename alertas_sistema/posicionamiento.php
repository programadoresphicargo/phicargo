<?php
$fechaHora = date('Y-m-d H:i:s');

require_once('../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT unidad, fecha_hora, ultima_ubicacion.estado FROM `ultima_ubicacion` INNER JOIN `unidades` ON unidades.placas COLLATE utf8mb4_general_ci = ultima_ubicacion.placas COLLATE utf8mb4_general_ci where unidades.estado = 'FUERA' and ultima_ubicacion.estado = 'activo'";
$resultado = $cn->query($sql);
while ($row = $resultado->fetch_assoc()) {
    $ultima_hora = $row['fecha_hora'];
    $horaLimite = strtotime('-20 minutes');

    if (strtotime($ultima_hora) <= $horaLimite) {
        echo '  ' . $row['unidad'] . '  ';
    }
}
