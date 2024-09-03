<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d H:i:s');

$id_usuario = $_POST['id_usuario'];
$id_entrega = $_POST['id_entrega'];

$sqlSelect = "SELECT * FROM entregas_turnos_visto where id_usuario = $id_usuario and id_entrega = $id_entrega";
$resultado = $cn->query($sqlSelect);

if ($resultado->num_rows <= 0) {
    $sqlInsert = "INSERT INTO entregas_turnos_visto VALUES(NULL,$id_entrega,$id_usuario,'$fecha')";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
}else{
    echo 1;
}
