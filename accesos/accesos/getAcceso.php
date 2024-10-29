<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_acceso = $_GET['id_acceso'];
$SQL = "SELECT 
*,
u_creacion.nombre AS usuario_creacion,
u_valido.nombre AS usuario_valido,
u_archivo.nombre AS usuario_archivo
FROM 
accesos a
left JOIN 
usuarios u_creacion ON a.usuario_creacion = u_creacion.id_usuario
left JOIN 
usuarios u_valido ON a.usuario_valido = u_valido.id_usuario
left JOIN 
usuarios u_archivo ON a.usuario_archivo = u_archivo.id_usuario
WHERE 
a.id_acceso = $id_acceso";

$resultado = $cn->query($SQL);

if ($resultado) {
    $resultados_array = array();
    while ($fila = $resultado->fetch_assoc()) {
        $resultados_array[] = $fila;
    }

    $json_resultados = json_encode($resultados_array);

    echo $json_resultados;
} else {
    echo "Error en la consulta: " . $cn->error;
}

$cn->close();
