<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_evento = $_GET['id_evento'];
$sql = "SELECT *  FROM comentarios_eventos inner join usuarios on usuarios.id_usuario = comentarios_eventos.usuario_creacion where id_evento = $id_evento order by fecha_creacion desc";

$resultado = mysqli_query($cn, $sql);
$eventos = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    $eventos[] = $row;
}

echo json_encode($eventos);
