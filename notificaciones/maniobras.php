<?php
require_once('../mysql/conexion.php');
require_once('notificaciones.php');

$cn = conectar();
$sql = "SELECT employee_id from viajes where estado = 'Activo'";
$result = $cn->query($sql);

while ($row = $result->fetch_assoc()) {
    enviar_notificacion('¡Tus status son muy importantes!', 'No olvides enviar tus status en la aplicación.', $row['employee_id']);
    echo 'Notificación enviada a ' . $row['employee_id'] . "<br>";
}
