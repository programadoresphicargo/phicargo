<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];
$SqlSelect = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo' and status != 'cancelado'";
$result = $cn->query($SqlSelect);
$row = $result->fetch_assoc();

if ($result->num_rows == 0) {
    echo 0;
} else {
    if ($row['status'] == 'Activo') {
        echo 1;
    } else if ($row['status'] == 'Finalizado') {
        echo 2;
    } else if ($row['status'] == 'Disponible') {
        echo 3;
    }
}
