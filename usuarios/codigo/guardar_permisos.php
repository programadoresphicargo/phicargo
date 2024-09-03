<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_usuario = $_POST['id_usuario'];
$id_permiso = $_POST['id_permiso'];

$sqlSelect = "SELECT * FROM permisos_usuarios where id_usuario = $id_usuario and id_permiso = $id_permiso";
$resultado = $cn->query($sqlSelect);
$sqlInsert = "INSERT INTO permisos_usuarios VALUES(NULL,$id_usuario,$id_permiso)";

if ($resultado->num_rows > 0) {
    echo 2;
} else {
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
}
