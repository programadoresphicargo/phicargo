<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
$id = $_POST['id'];
$tipo = $_POST['tipo'];

$sql = "SELECT status from maniobras where id_cp = $id and tipo = '$tipo' order by fecha_inicio desc";
$resultado = $cn->query($sql);
$row = $resultado->fetch_array();
if ($resultado->num_rows > 0) {
    if ($row['status'] == 'Finalizado') {
        echo 1;
    } else if ($row['status'] == 'Activo') {
        echo 3;
    } else {
        echo 0;
    }
} else {
    echo 2;
}
