<?php
require_once('../../mysql/conexion.php');
require_once('../cola/funcion_enviar_cola.php');
$cn = conectar();

session_start();

$id_usuario = $_SESSION['userID'];
$id_turno = $_POST['id_turno'];
$id_operador = $_POST['id_operador'];
$sucursal = $_POST['sucursal'];
$fecha_hora_actual = date("Y-m-d H:i:s");
$tipo_incidencia = $_POST['tipo_incidencia'];
$comentarios_incidencias = $_POST['comentarios_incidencias'];

$fecha_actual = new DateTime();

$fecha_7_dias_despues = clone $fecha_actual;
$fecha_7_dias_despues->modify('+3 days');

$fecha_15_dias_despues = clone $fecha_actual;
$fecha_15_dias_despues->modify('+5 days');

$fecha7 = $fecha_7_dias_despues->format('Y-m-d');
$fecha15 = $fecha_15_dias_despues->format('Y-m-d');

$sql = "INSERT INTO incidencias VALUES(NULL,$id_operador,'$fecha_hora_actual',$id_usuario,'$tipo_incidencia','$comentarios_incidencias', NULL)";
$cn->query($sql);

$sql2 = "SELECT * FROM incidencias where id_operador = $id_operador";
$resultado2 = $cn->query($sql2);
$variable = $resultado2->num_rows;

switch ($variable) {
    case 0:
        enviar_cola($id_turno, $sucursal, $fecha7 . ' 09:00:00');
        break;
    case 1:
        enviar_cola($id_turno, $sucursal, $fecha15 . ' 09:00:00');
        break;
    case ($variable >= 2):
        echo 1;
        break;
    default:
        break;
}
