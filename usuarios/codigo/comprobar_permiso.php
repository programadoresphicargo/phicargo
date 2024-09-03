<?php

require_once('../../mysql/conexion.php');

function comprobar_permiso($id_permiso)
{

    $cn = conectar();
    $id = $_SESSION['userID'];
    $sqlSelect = "SELECT id_permiso from permisos_usuarios where id_usuario = $id and id_permiso = $id_permiso";
    $resultado = $cn->query($sqlSelect);
    if ($resultado->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
