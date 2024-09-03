<?php

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");
require_once('../../mysql/conexion.php');
require_once('../algoritmos/obtener_turnos.php');

$cn = conectar();
$sql = "SELECT * from cola left join turnos on turnos.id_turno = cola.id_turno where cola_estado = 'espera' order by id_cola asc";
$result = $cn->query($sql);

while ($row = $result->fetch_assoc()) {
    if ($row['fecha_hora_salida'] <= $hora) {
        $id_cola = $row['id_cola'];
        $id_turno = $row['id_turno'];
        $sucursal = $row['sucursal'];

        $sqlUpdate = "UPDATE cola set cola_estado = 'liberado' where id_cola = $id_cola";
        if ($cn->query($sqlUpdate)) {
            echo 1;
        } else {
            echo 0;
        }

        $turno = obtener_turnos($sucursal) + 1;
        $sqlUpdate = "UPDATE turnos set cola = false, turno = $turno where id_turno = $id_turno";
        if ($cn->query($sqlUpdate)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo $row['id_cola'] . ' / ' . $row['id_turno'] . ' / ' . $row['fecha_hora_salida'] . '<br>';
    }
}
