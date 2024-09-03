<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_operador = $_POST['id_operador'];

$sqlSelect = "SELECT * FROM votos where id_operador = $id_operador";
$resultado = $cn->query($sqlSelect);
if ($resultado->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
