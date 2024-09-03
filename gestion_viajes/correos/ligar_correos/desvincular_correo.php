<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$id = $_POST['id'];
$sqlDelete = "DELETE FROM correos_viajes WHERE id = $id";
if ($cn->query($sqlDelete)) {
    echo 1;
} else {
    echo 0;
}
