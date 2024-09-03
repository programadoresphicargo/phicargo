<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d H:i:s');

$sql = "SELECT * FROM notificaciones where evento = 'estatus operador'";
$resultado = $cn->query($sql);
while ($row = $resultado->fetch_assoc()) {
    $id_notificacion = $row['id'];
    $sql3 = "SELECT * FROM control_notificaciones where id_notificacion = $id_notificacion and id_usuario = $id_usuario";
    $resultado3 = $cn->query($sql3);
    if ($resultado3->num_rows <= 0) {
        $sql2 = "INSERT INTO control_notificaciones VALUES(NULL,$id_notificacion,$id_usuario,1,'$fecha_actual')";
        if ($cn->query($sql2)) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
