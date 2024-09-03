<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
$fecha = date('Y-m-d H:i:s');

$id_usuario = $_POST['id_usuario'];

$sqlSelect = "SELECT * FROM entrega_turnos where id_usuario = $id_usuario and estado = 'abierto'";
$result = $cn->query($sqlSelect);
if ($result->num_rows != 0) {
    $row = $result->fetch_assoc();
    $id_entrega = $row['id'];
    $id_viaje = $_POST['id_viaje'];
    $texto = $_POST['texto'];

    $sqlInsert = "INSERT INTO entrega_viajes VALUES(NULL,$id_entrega,$id_viaje,'$texto',$id_usuario,'$fecha')";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
}else{
    echo 2;
}
