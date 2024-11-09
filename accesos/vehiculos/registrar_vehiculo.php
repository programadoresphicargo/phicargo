<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];
$data = json_decode(file_get_contents("php://input"), true);

date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');

if ($data) {
    $marca = $data['marca'] ?? '';
    $modelo = $data['modelo'] ?? '';
    $placas = $data['placas'] ?? '';
    $tipoVehiculo = $data['tipoVehiculo'] ?? '';
    $color = $data['color'] ?? '';
    $contenedor1 = $data['contenedor1'] ?? '';
    $contenedor2 = $data['contenedor2'] ?? '';

    $sql = "INSERT INTO vehiculos (marca, modelo, placas, tipo_vehiculo, color, contenedor1, contenedor2, usuario_creacion, fecha_creacion) 
            VALUES ('$marca', '$modelo', '$placas', '$tipoVehiculo', '$color', '$contenedor1', '$contenedor2',$id_usuario,'$fechaHora')";

    if ($cn->query($sql) === TRUE) {
        echo json_encode(["mensaje" => "Vehiculo guardado correctamente."]);
    } else {
        echo json_encode(["error" => "Error al guardar los datos: " . $cn->error]);
    }

    $cn->close();
} else {
    echo json_encode(["error" => "No se recibieron datos"]);
}
