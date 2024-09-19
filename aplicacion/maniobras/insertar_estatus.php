<?php
require_once('../../postgresql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('funcion_envio_estatus.php');
$cn = conectar();

date_default_timezone_set("America/Mexico_City");
$fecha_hora = date('Y-m-d H:i:s');
$id_maniobra = $_POST['id_maniobra'];
$estatus_nombre = $_POST['estatus_nombre'];
$comentarios = $_POST['comentarios'];

$datos = [
    'id_maniobra' => $id_maniobra,
    'id_estatus' => $_POST['id_estatus'],
    'estatus_nombre' => $estatus_nombre,
    'operador_id' => $_POST['operador_id'],
    'vehiculo_id' => $_POST['vehiculo_id'],
    'latitud' => $_POST['latitud'],
    'longitud' => $_POST['longitud'],
    'localidad' => $_POST['localidad'],
    'sublocalidad' => $_POST['sublocalidad'],
    'calle' => $_POST['calle'],
    'codigo_postal' => $_POST['codigo_postal'],
    'comentarios' => $comentarios,
];

$archivos = $_FILES;

echo actualizarEstadoViaje($datos, $archivos);

if ($_POST['id_status'] == 94) {
    try {
        $sqlReporte = "INSERT INTO reportes VALUES(NULL,$id_viaje,NULL,'$comentarios',NULL,'$fecha_hora',NULL,NULL,NULL)";
        $cn->query($sqlReporte);
        $lastIdReporte = $cn->insert_id;

        $sqlNoti = "INSERT INTO notificaciones VALUES(NULL,'Operador tiene un problema',$id_viaje,NULL,'$fecha_hora','problema viaje')";
        $cn->query($sqlNoti);

        $lastIdNoti = $cn->insert_id;

        file_put_contents('notificaciones_log.txt', "Proceso exitoso - Reporte ID: $lastIdReporte, Notificación ID: $lastIdNoti\n", FILE_APPEND);
    } catch (Exception $e) {
        file_put_contents('notificaciones_log.txt', "Error: " . $e->getMessage() . " - Línea: " . $e->getLine() . " - Consulta: $sqlReporte\n", FILE_APPEND);
        file_put_contents('notificaciones_log.txt', "Error: " . $e->getMessage() . " - Línea: " . $e->getLine() . " - Consulta: $sqlNoti\n", FILE_APPEND);
    }
} else {
    $descripcion = 'Nuevo estatus: ' . $estatus_nombre;
    $sqlNoti = "INSERT INTO notificaciones VALUES(NULL,'$descripcion',$id_viaje, NULL,'$fecha_hora','estatus operador')";
    try {
        $cn->query($sqlNoti);
        $lastIdNoti = $cn->insert_id;
        file_put_contents('notificaciones_log.txt', "Proceso exitoso - Notificación ID: $lastIdNoti\n", FILE_APPEND);
    } catch (Exception $e) {
        file_put_contents('notificaciones_log.txt', "Error: " . $e->getMessage() . " - Línea: " . $e->getLine() . " - Consulta: $sqlNoti\n", FILE_APPEND);
    }
}
