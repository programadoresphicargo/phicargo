<?php

function actualizarEstadoViaje($datos, $archivos)
{
    $cn = conectar();
    $log_file = 'errors_log.txt'; // Ruta al archivo de registro de errores

    try {
        // Iniciar transacción
        $cn->begin_transaction();

        // Extracción de datos del array asociativo
        $id_viaje = $datos['id_viaje'];
        $id_status = $datos['id_status'];
        $status_nombre = $datos['status_nombre'];
        $id_usuario = $datos['id_operador'];
        $id_vehiculo = $datos['id_vehiculo'];
        $latitud = $datos['latitud'];
        $longitud = $datos['longitud'];
        $localidad = preg_replace('/[^a-zA-Z0-9\s]/', '', $datos['localidad']);
        $sublocalidad = preg_replace('/[^a-zA-Z0-9\s]/', '', $datos['sublocalidad']);
        $calle = preg_replace('/[^a-zA-Z0-9\s]/', '', $datos['calle']);
        if ($datos['codigo_postal'] == '' || $datos['codigo_postal'] == null) {
            $codigo_postal = 0;
        } else {
            $codigo_postal = $datos['codigo_postal'];
        }
        $comentarios = $datos['comentarios'];

        // Extracción de placas
        $partes = explode(' [', $id_vehiculo);
        $placas = rtrim($partes[1], ']');

        // Fecha y hora actual
        $fecha_hora = date("Y-m-d H:i:s");

        // Insertar en ubicaciones_estatus
        $sqlInsert = "INSERT INTO ubicaciones_estatus VALUES(NULL, '$placas', $latitud, $longitud, '$localidad', '$sublocalidad', '$calle', $codigo_postal, '$fecha_hora')";
        if (!$cn->query($sqlInsert)) {
            throw new Exception("Error al insertar en ubicaciones_estatus: " . $cn->error, 0, null, $sqlInsert);
        }
        $id_ubicacion = $cn->insert_id;

        // Insertar en reportes_estatus_viajes
        $sqlInsert = "INSERT INTO reportes_estatus_viajes VALUES(NULL, $id_viaje, $id_status, $id_ubicacion, $id_usuario, '$fecha_hora', '$comentarios')";
        if (!$cn->query($sqlInsert)) {
            throw new Exception("Error al insertar en reportes_estatus_viajes: " . $cn->error, 0, null, $sqlInsert);
        }
        $id_reporte = $cn->insert_id;

        $uploaded_images = array();
        if (!empty($archivos)) {
            $target_dir = "../../gestion_viajes/adjuntos_estatus/$id_viaje/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            foreach ($archivos as $file) {
                if ($file["error"] === UPLOAD_ERR_OK) {
                    $original_name = basename($file["name"]);
                    $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                    $unique_name = date('YmdHis') . '_' . uniqid() . '.' . $file_extension;
                    $target_file = $target_dir . $unique_name;
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        $file_type = mime_content_type($target_file);
                        $sqlAd = "INSERT INTO archivos_adjuntos VALUES (NULL, $id_reporte, '$unique_name', '$file_type', $id_usuario, '$fecha_hora')";
                        if (!$cn->query($sqlAd)) {
                            throw new Exception("Error al insertar en archivos_adjuntos: " . $cn->error, 0, null, $sqlAd);
                        }
                        $uploaded_images[] = $target_file;
                    } else {
                        throw new Exception("Failed to move uploaded file: " . $file["name"], 0, null, null);
                    }
                } else {
                    throw new Exception("File upload error (code " . $file["error"] . ") for file: " . $file["name"], 0, null, null);
                }
            }
        }

        global $models, $db, $uid, $password;
        if (!empty($uid)) {
            $values = [
                'travel_id' => $id_viaje,
                'status' => $status_nombre,
                'location' => $latitud . ',' . $longitud,
                'name' => $comentarios,
                'x_envio' => 'Operador',
            ];
            $partners = $models->execute_kw(
                $db,
                $uid,
                $password,
                'tms.travel.history.events',
                'create',
                [$values]
            );
        }

        // Confirmar transacción
        $cn->commit();

        // Registrar éxito
        logSuccess($log_file, $id_reporte);

        return 1;
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $cn->rollback();

        // Registrar error
        logError($log_file, $e->getMessage(), $e->getCode(), $e->getPrevious(), $e->getTrace(), $sqlInsert);
        echo $e->getMessage();
        return 0;
    }
}

function logError($file, $error, $code, $previous, $trace, $sqlInsert = '')
{
    $caller = $trace[0]; // Llamada del error
    $file_name = $caller['file'];
    $line = $caller['line'];
    $sql = isset($previous) ? $previous->getMessage() : "";
    $consulta = !empty($sqlInsert) ? " - SQL: $sqlInsert" : "";

    // Mensaje de registro
    $log_message = date('Y-m-d H:i:s') . " - File: $file_name - Line: $line - SQL: $sql - Error: $error - Consulta - $consulta - $code\n";
    file_put_contents($file, $log_message, FILE_APPEND);
}

function logSuccess($file, $id_reporte)
{
    // Obtiene la información de la llamada actual de la función
    $backtrace = debug_backtrace();
    $caller = $backtrace[1]; // Llamada del éxito (función que llamó a logSuccess)
    $line = $caller['line'];
    $function = $caller['function'];
    $file_name = $caller['file'];

    // Mensaje de registro
    $log_message = date('Y-m-d H:i:s') . " - Function: $function - Line: $line - Success: Completed successfully with id_reporte = $id_reporte\n";
    file_put_contents($file, $log_message, FILE_APPEND);
}
