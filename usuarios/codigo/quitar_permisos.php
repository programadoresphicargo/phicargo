<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_usuario = $_POST['id_usuario'];
$id_permiso = $_POST['id_permiso'];

$sqlDelete = "DELETE FROM permisos_usuarios where id_usuario = $id_usuario and id_permiso = $id_permiso";
if ($cn->query($sqlDelete)) {
    echo 1;
} else {
    echo 0;
}
