<?php

require_once('../mysql/conexion.php');

$cn = conectar();
$sql = "SELECT placas from unidades";
$result = $cn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $placas = $row['placas'];

    $sql = "SELECT id, velocidad, fecha_hora FROM ubicaciones WHERE placas = '$placas' ORDER BY fecha_hora DESC LIMIT 1";
    $resultado = $cn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $id_ubicacion = $fila['id'];
        $ultimaVelocidad = $fila['velocidad'];
        $fechaHora = $fila['fecha_hora'];

        $sql = "SELECT * FROM detenciones WHERE placas = '$placas' and fin_detencion IS NULL LIMIT 1";
        $resultadoDetencion = $cn->query($sql);

        if ($ultimaVelocidad < 1.0) {
            if ($resultadoDetencion->num_rows > 0) {
            } else {
                $sql = "INSERT INTO detenciones VALUES (NULL,'$placas',$id_ubicacion, '$fechaHora',null,'')";
                echo $sql;
                $cn->query($sql);
            }
        } else {
            if ($resultadoDetencion->num_rows > 0) {
                $registroDetencion = $resultadoDetencion->fetch_assoc();
                $idDetencion = $registroDetencion['id_detencion'];
                $sql = "UPDATE detenciones SET fin_detencion = '$fechaHora' WHERE id_detencion = $idDetencion";
                $cn->query($sql);
            }
        }
    }
}
