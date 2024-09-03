<?php

require_once('../mysql/conexion.php');

$cn = conectar();
$sql = "SELECT id, placas from viajes where estado = 'Activo'";
$result = $cn->query($sql);

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $placas = $row['placas'];

    echo $id . "<br>";
    echo $placas . "<br>";

    $sqlUltimaUbicacion = "SELECT id, velocidad, fecha_hora from ubicaciones where placas = '$placas' order by fecha_hora desc limit 1";
    $resultSet = $cn->query($sqlUltimaUbicacion);
    $row2 = $resultSet->fetch_assoc();
    $id_ubicacion = $row2['id'];
    $fecha = $row2['fecha_hora'];

    $sqlHoraDetencion = "SELECT fecha_inicio_detencion from unidades where placas = '$placas'";
    $resultHoraDetencion = $cn->query($sqlHoraDetencion);
    $rowHoraDetencion = $resultHoraDetencion->fetch_assoc();
    $fid = $rowHoraDetencion['fecha_inicio_detencion'];

    $sqlPlanta = "SELECT status from correos WHERE id_viaje = $id and (status = 'LLEGADA A PLANTA' or status = 'INGRESO A PLANTA' or status='Asignación de Rampa' or status='Inicio de carga o descarga' or status='Fin de carga o descarga')";
    $resultPlanta = $cn->query($sqlPlanta);

    $sqlSalidaPlanta = "SELECT status from correos WHERE id_viaje = $id and status = 'SALIDA DE PLANTA'";
    $resultSalidaPlanta = $cn->query($sqlSalidaPlanta);

    try {
        if ($row2['velocidad'] == 0) {

            if (empty($fid)) {
                $sqlUpdate = "UPDATE unidades set fecha_inicio_detencion = '$fecha' where placas = '$placas'";
                $cn->query($sqlUpdate);
                if ($resultSalidaPlanta->num_rows > 0) {
                    $sqlInsert = "INSERT INTO detenciones VALUES(null,$id,$id_ubicacion,'$fecha',NULL,'RUTA')";
                    $cn->query($sqlInsert);
                } else if ($resultPlanta->num_rows > 0) {
                    $sqlInsert = "INSERT INTO detenciones VALUES(null,$id,$id_ubicacion,'$fecha',NULL,'PLANTA')";
                    $cn->query($sqlInsert);
                } else {
                    $sqlInsert = "INSERT INTO detenciones VALUES(null,$id,$id_ubicacion,'$fecha',NULL,'RUTA')";
                    $cn->query($sqlInsert);
                }
                echo "1<br>";
            } else {
                echo "2<br>";
            }
        } else {
            $sqlUpdate = "UPDATE unidades set fecha_inicio_detencion = null where placas = '$placas'";
            $cn->query($sqlUpdate);
            $sqlDetencion = "SELECT id_detencion, fin_detencion from detenciones where id_viaje = $id order by id_detencion desc limit 1";
            $resultDetencion = $cn->query($sqlDetencion);
            $rowDetencion = $resultDetencion->fetch_assoc();
            if (empty($rowDetencion['id_detencion'])) {
                $id_detencion = 0;
            } else {
                $id_detencion = $rowDetencion['id_detencion'];
            }
            if (empty($rowDetencion['fin_detencion'])) {
                $update = "UPDATE detenciones set fin_detencion = '$fecha' where id_detencion = $id_detencion";
                $cn->query($update);
                echo "3<br>";
            }
        }

        echo "4<br>";
    } catch (Exception $e) {
        echo '-->';
        echo $e->getMessage();
        echo '<--';
    }
}
