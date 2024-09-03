<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];

$sql_select = "SELECT * FROM usuarios_clientes where id_usuario = $id_usuario and numero_celular is null";
$result = $cn->query($sql_select);
if ($result) {
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
}
