<?php

require_once "../../../mysql/conexion.php";

$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$id_correo = $_POST['id_correo'];

$selectQuery   = ("SELECT * from correos_viajes where id_viaje = $id_viaje and id_correo = $id_correo");
$query = mysqli_query($cn, $selectQuery);
$total = mysqli_num_rows($query);

if ($total <= 0) {
    $sqlInsert = "INSERT INTO correos_viajes VALUES(NULL,$id_viaje,$id_correo)";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
