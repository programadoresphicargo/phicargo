<?php
require_once('../../notificaciones/notificaciones.php');
require_once('../../mysql/conexion.php');

$cn = conectar();
$sql = "SELECT * FROM `operadores` WHERE activo = 1 AND token != '' AND token != '0' ORDER BY `operadores`.`identifier` ASC";
$result = $cn->query($sql);

while ($row = $result->fetch_assoc()) {
    enviar_notificacion('¡Nuevo comunicado importante!', 'Nuevo Boletín Disponible para Tu Información', $row['id']);
    echo 'Notificación enviada a ' . $row['id'] . "<br>";
}
