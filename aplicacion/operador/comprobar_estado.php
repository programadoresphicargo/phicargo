<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_operador = $_POST['id_operador'];

$sql = "SELECT * FROM operadores where id = $id_operador and activo = 1";
$resultado = $cn->query($sql);
if ($resultado->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
