<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
set_time_limit(600);

try {
    $cn->begin_transaction();

    $sql = "SELECT * FROM correos where id_ubicacion is null";
    $resultado = $cn->query($sql);

    while ($row = $resultado->fetch_assoc()) {

        if ($row['id_ubicacion'] != null) {

            $id_ubicacion = $row['id_ubicacion'];
            $id_viaje = $row['id_viaje'];
            $status = $row['status'];
            if ($row['usuario'] != null) {
                $id_usuario = $row['usuario'];
            } else {
                $id_usuario = 172;
            }
            $fecha_envio = $row['fecha_envio'];
            $comentarios = $row['comentarios'];

            $sqlUbi = "SELECT * FROM ubicaciones where id = $id_ubicacion";
            $resultadoUbi = $cn->query($sqlUbi);
            while ($rowUbi = $resultadoUbi->fetch_assoc()) {
                $placas = $rowUbi['placas'];
                $latitud = $rowUbi['latitud'];
                $longitud = $rowUbi['longitud']; // Corregido 'latitud' a 'longitud'
                $referencia = $rowUbi['referencia'];
                $calle = $rowUbi['calle'];
                $velocidad = $rowUbi['velocidad'];
                $fecha_hora = $rowUbi['fecha_hora'];
                $sqlUbicacionEstatus = "INSERT INTO ubicaciones_estatus VALUES(NULL,'$placas',$latitud,$longitud,'$referencia','$referencia','$calle',0,'$fecha_hora')";
                if ($cn->query($sqlUbicacionEstatus)) {
                    $last_id_ubi = $cn->insert_id;
                    $id_status = buscar_status($status);
                    if ($id_status != null) {
                    } else {
                        $id_status = 2;
                    }
                    $sqlInsertEstatus = "INSERT INTO reportes_estatus_viajes VALUES(NULL,$id_viaje,$id_status,$last_id_ubi,$id_usuario,'$fecha_envio','$comentarios')";
                    if ($cn->query($sqlInsertEstatus)) {
                    } else {
                    }
                }
            }
        } else {

            $id_viaje = $row['id_viaje'];
            $sqlviaje = "SELECT * FROM viajes where id = $id_viaje";
            $resultviaje = $cn->query($sqlviaje);
            $rowviaje = $resultviaje->fetch_assoc();
            $plaquitas = $rowviaje['placas'];
            $status = $row['status'];
            if ($row['usuario'] != null) {
                $id_usuario = $row['usuario'];
            } else {
                $id_usuario = 172;
            }
            $fecha_envio = $row['fecha_envio'];
            $comentarios = $row['comentarios'];


            $locacion = $row['location'];
            $pattern_full = '/^\s*(-?\d+(\.\d+)?)[\s,]+(-?\d+(\.\d+)?)[\s,]*(.*?)[\s,]*(México)[\s,]*(\d{5})?\s*(.*?)\s*$/i';
            preg_match($pattern_full, $locacion, $matches_full);
            if (count($matches_full) >= 6) {
                $latitud = $matches_full[1];
                $longitud = $matches_full[3];
                $address = isset($matches_full[4]) ? trim($matches_full[4]) : '';
                $state = $matches_full[5];
                $postalCode = isset($matches_full[6]) ? $matches_full[6] : '';
                $city = isset($matches_full[7]) ? trim($matches_full[7]) : '';

                $sqlUbicacionEstatus = "INSERT INTO ubicaciones_estatus VALUES(NULL,'$plaquitas',$latitud,$longitud,'$address','$address','$address',0,'$fecha_envio')";
                if ($cn->query($sqlUbicacionEstatus)) {
                    $last_id_ubi = $cn->insert_id;
                    $id_status = buscar_status($status);
                    if ($id_status != null) {
                    } else {
                        $id_status = 2;
                    }
                    $sqlInsertEstatus = "INSERT INTO reportes_estatus_viajes VALUES(NULL,$id_viaje,$id_status,$last_id_ubi,$id_usuario,'$fecha_envio','$comentarios')";
                    if ($cn->query($sqlInsertEstatus)) {
                    } else {
                        echo 'error------------------------------------' . '<br>';
                    }
                } else {
                    echo 'error------------------------------------' . '<br>';
                }
            } else {

                if (!empty($locacion)) {
                    list($latitud, $longitud) = explode(" , ", $locacion);
                    echo $locacion . '<br>';

                } else {
                    echo 'vacio' . $locacion . '<br>';
                }
            }
        }
    }

    $cn->commit();
} catch (Exception $e) {
    $cn->rollback();
    echo "Error: " . $e->getMessage() . " en la línea " . $e->getLine();
}

function buscar_status($nombre)
{
    require_once('../../mysql/conexion.php');
    $cn = conectar();
    $sql = "SELECT * FROM status WHERE status = '$nombre'";
    $resultado = $cn->query($sql);
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['id_status'];
    } else {
        if ($nombre == 'EN MOVIMIENTO') {
            return 102;
        } else if ($nombre == 'DETENIDO') {
            return 101;
        } else {
            return null;
        }
    }
}
