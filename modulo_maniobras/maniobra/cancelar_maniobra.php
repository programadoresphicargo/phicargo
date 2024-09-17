<?php
require_once('../../postgresql/conexion.php');
session_start();
$cn = conectar();

$id_maniobra = $_GET['id_maniobra'];
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$sql = "UPDATE maniobras 
        SET estado_maniobra = 'cancelada',
            usuario_cancelacion = :id_usuario,
            fecha_cancelacion = :fechaHora
        WHERE id_maniobra = :id_maniobra";

$stmt = $cn->prepare($sql);

$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->bindParam(':fechaHora', $fechaHora);
$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo 1;
} else {
    echo 0;
}
