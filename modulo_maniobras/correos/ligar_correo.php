<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_cp = $_POST['id_cp'];
$id_correo = $_POST['id_correo'];
$SqlInsert = "INSERT INTO correos_maniobras VALUES (NULL,$id_cp,$id_correo)";
$SqlSelect = "SELECT * FROM correos_maniobras where id_correo = $id_correo and id_cp = $id_cp";
$resultado = $cn->query($SqlSelect);

if ($resultado->num_rows <= 0) {
    if ($cn->query($SqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 2;
}
