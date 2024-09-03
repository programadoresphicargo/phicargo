<?php
require_once('../../mysql/conexion.php');

session_start();
$id_usuario = $_SESSION['userID'];
$nombre_empresa = $_POST['nombre_empresa'];
$fechaHoraActual = date('Y-m-d H:i:s');

$cn = conectar();

// Verificar si la empresa ya existe
$sql_verificar = "SELECT COUNT(*) as count FROM empresas_accesos WHERE nombre_empresa = '$nombre_empresa'";
$resultado_verificacion = $cn->query($sql_verificar);
if ($resultado_verificacion) {
    $fila = $resultado_verificacion->fetch_assoc();
    $cantidad_empresas = $fila['count'];
    if ($cantidad_empresas > 0) {
        // La empresa ya existe, no la insertes
        echo json_encode(["success" => false, "message" => "La empresa ya existe"]);
        exit(); // Salir del script
    }
} else {
    // Ocurrió un error al ejecutar la consulta de verificación
    echo json_encode(["success" => false, "message" => "Error en la consulta de verificación"]);
    exit(); // Salir del script
}

// Insertar la empresa si no existe
$sql_insertar = "INSERT INTO empresas_accesos VALUES(NULL, '$nombre_empresa', $id_usuario, '$fechaHoraActual')";
if ($cn->query($sql_insertar)) {
    $nuevo_id = $cn->insert_id; // Obtener el ID autoincremental generado
    echo json_encode(["success" => true, "id" => $nuevo_id]);
} else {
    echo json_encode(["success" => false, "message" => "Error al insertar la empresa"]);
}
