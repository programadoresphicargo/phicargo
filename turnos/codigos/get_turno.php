<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_turno = $_POST['id_turno'];

$stmt = $cn->prepare("SELECT * FROM turnos 
inner join operadores on operadores.id = turnos.id_operador 
inner join unidades on unidades.placas = turnos.placas 
inner join usuarios on usuarios.id_usuario = turnos.usuario_registro
WHERE id_turno = ?");

$stmt->bind_param("i", $id_turno);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);
