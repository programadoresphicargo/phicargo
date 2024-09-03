<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (empty($_GET['busqueda'])) {
    $sql = "SELECT *, entrega_turnos.estado as status FROM entrega_turnos inner join usuarios on usuarios.id_usuario = entrega_turnos.id_usuario";
} else {
    $busqueda = $_GET['busqueda'];
    $sql = "SELECT *, entrega_turnos.estado as status FROM entrega_turnos inner join usuarios on usuarios.id_usuario = entrega_turnos.id_usuario where titulo like '%$busqueda%'";
}

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
        'usuario' => $row['id_usuario'],
        'nombre_usuario' => $row['nombre'],
        'estado' => $row['status'],
    );
}

echo json_encode($eventos);
