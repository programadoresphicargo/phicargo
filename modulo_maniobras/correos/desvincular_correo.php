<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_cp = $_POST['id_cp'];
$id_correo = $_POST['id_correo'];
$SqlDelete = "DELETE FROM correos_maniobras where id_correo = $id_correo and id_cp = $id_cp";
if ($cn->query($SqlDelete)) {
    echo 1;
} else {
    echo 0;
}
