<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sqlSelect = "SELECT * from correos_viajes where id_viaje = $id_viaje";
$result = $cn->query($sqlSelect);
if ($result->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
