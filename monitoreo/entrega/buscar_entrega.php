<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id = $_GET['id'];
$sql = "SELECT * FROM entrega_turnos inner join usuarios on usuarios.id_usuario = entrega_turnos.usuario where id = $id";
$resultado = mysqli_query($cn, $sql);

$eventos = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    $eventos[] = array(
        'id' => $row['id'],
        'title' => $row['titulo'],
        'texto' => $row['texto'],
        'start' => $row['fecha_inicio'],
        'end' => $row['fecha_fin'],
        'color' => $row['color'],
        'usuario' => $row['usuario'],
        'nombre_usuario' => $row['nombre'],
    );
}

echo json_encode($eventos);
