<?php

function actualizarEstadoViaje($datos, $archivos)
{
    $cn = conectarPostgresql();
    $log_file = 'errors_log.txt'; // Ruta al archivo de registro de errores

    try {
        // Iniciar transacción
        $cn->beginTransaction();

        // Extracción de datos del array asociativo
        $id_maniobra = $datos['id_maniobra'];
        $id_estatus = $datos['id_estatus'];
        $estatus_nombre = $datos['estatus_nombre'];
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

        $placas = rtrim('AHS');

        $fecha_hora = date("Y-m-d H:i:s");

        $sqlInsert = "INSERT INTO ubicaciones_maniobras (placas, latitud, longitud, localidad, sublocalidad, calle, codigo_postal, fecha_hora) 
        VALUES (:placas, :latitud, :longitud, :localidad, :sublocalidad, :calle, :codigo_postal, :fecha_hora) 
        RETURNING id_ubicacion";

        $stmt = $cn->prepare($sqlInsert);

        $stmt->bindParam(':placas', $placas);
        $stmt->bindParam(':latitud', $latitud);
        $stmt->bindParam(':longitud', $longitud);
        $stmt->bindParam(':localidad', $localidad);
        $stmt->bindParam(':sublocalidad', $sublocalidad);
        $stmt->bindParam(':calle', $calle);
        $stmt->bindParam(':codigo_postal', $codigo_postal, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora', $fecha_hora);

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar en ubicaciones_estatus_maniobras: " . implode(" ", $stmt->errorInfo()));
        }

        $id_ubicacion = $stmt->fetchColumn();

        $sqlInsert = "INSERT INTO reportes_estatus_maniobras (id_maniobra, id_estatus, id_ubicacion, id_usuario, fecha_hora, comentarios_estatus) 
        VALUES (:id_maniobra, :id_estatus, :id_ubicacion, :id_usuario, :fecha_hora, :comentarios_estatus) 
        RETURNING id_reporte";

        $stmt = $cn->prepare($sqlInsert);

        $stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
        $stmt->bindParam(':id_estatus', $id_estatus, PDO::PARAM_INT);
        $stmt->bindParam(':id_ubicacion', $id_ubicacion, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora', $fecha_hora);
        $stmt->bindParam(':comentarios_estatus', $comentarios);

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar en reportes_estatus_maniobras: " . implode(" ", $stmt->errorInfo()));
        }

        $id_reporte = $stmt->fetchColumn();

        $uploaded_images = array();
        if (!empty($archivos)) {
            $target_dir = "../../gestion_viajes/adjuntos_estatus/$id_maniobra/";
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

        $cn->commit();
        logSuccess($log_file, $id_reporte);

        return 1;
    } catch (Exception $e) {
        $cn->rollback();
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
