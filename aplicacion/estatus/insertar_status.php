<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

date_default_timezone_set("America/Mexico_City");
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$referencia = $_POST['referencia'];
$id_status = $_POST['id_status'];
$status_nombre = $_POST['status_nombre'];
$id_usuario = $_POST['id_operador'];

$id_vehiculo = $_POST['id_vehiculo'];
$partes = explode(' [', $id_vehiculo);
$placas = rtrim($partes[1], ']');

$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
$localidad = $_POST['localidad'];
$sublocalidad = $_POST['sublocalidad'];
$calle = $_POST['calle'];
$codigo_postal = $_POST['codigo_postal'];
$fecha_hora = date("Y-m-d H:i:s");

$velocidad = 0;
$comentarios = $_POST['comentarios'];

$sqlInsert = "INSERT INTO ubicaciones_estatus VALUES(NULL, '$placas', $latitud, $longitud,'$localidad','$sublocalidad','$calle',$codigo_postal,'$fecha_hora')";
if ($cn->query($sqlInsert)) {
    $id_ubicacion = $cn->insert_id;
    $sqlInsert = "INSERT INTO reportes_estatus_viajes VALUES(NULL, $id_viaje, $id_status, $id_ubicacion,$id_usuario,'$fecha_hora','$comentarios')";
    if ($cn->query($sqlInsert)) {
        $id_reporte = $cn->insert_id;

        $target_dir = "../../gestion_viajes/adjuntos_estatus/$id_viaje/";
        if (!file_exists($target_dir)) {
            if (mkdir($target_dir, 0777, true)) {
            } else {
            }
        }

        $uploaded_images = array();

        foreach ($_FILES as $file) {
            if ($file["error"] === UPLOAD_ERR_OK) {
                $original_name = basename($file["name"]);
                $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                $unique_name = date('YmdHis') . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $unique_name;
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    $file_type = mime_content_type($target_file);
                    $sqlAd = "INSERT INTO archivos_adjuntos VALUES (NULL, $id_reporte, '$unique_name', '$file_type', $id_usuario, '$fecha_hora')";
                    $cn->query($sqlAd);
                    $uploaded_images[] = $target_file;
                } else {
                    //error_log("Failed to move uploaded file: " . $file["name"]);
                }
            } else {
                //error_log("File upload error (code " . $file["error"] . ") for file: " . $file["name"]);
            }
        }


        if (!empty($uid)) {
            $values = [
                'travel_id' => $id_viaje,
                'status' => $status_nombre,
                'location' => $latitud . $longitud,
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
            echo 1;
        } else {
            echo 0;
        }
    }
}

if ($id_status == 94) {
    try {
        $sqlReporte = "INSERT INTO reportes VALUES(NULL,$id_viaje,NULL,'$comentarios',NULL,'$fecha_hora',NULL,NULL,NULL)";
        $cn->query($sqlReporte);
        $sqlNoti = "INSERT INTO notificaciones VALUES(NULL,'Operador tiene un problema',$id_viaje,NULL,'$fecha_hora')";
        $cn->query($sqlNoti);
    } catch (Exception $e) {
    }
}
