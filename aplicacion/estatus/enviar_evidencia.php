<?php

require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');
require_once('funcion_envio_estatus.php');

$id_viaje = $_POST['id_viaje'];
$id_operador = $_POST['id_operador'];

$datos = [
    'id_viaje' => $id_viaje,
    'id_status' => 109,
    'status_nombre' => 'Envío de evidencia',
    'id_operador' => $id_operador,
    'id_vehiculo' => $_POST['id_vehiculo'],
    'latitud' => $_POST['latitud'],
    'longitud' => $_POST['longitud'],
    'localidad' => $_POST['localidad'],
    'sublocalidad' => $_POST['sublocalidad'],
    'calle' => $_POST['calle'],
    'codigo_postal' => $_POST['codigo_postal'],
    'comentarios' => 'Envío de evidencia',
];

$archivos = $_FILES;
echo actualizarEstadoViaje($datos, $archivos);
