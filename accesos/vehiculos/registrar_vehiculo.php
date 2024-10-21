<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $marca = $data['marca'] ?? '';
    $modelo = $data['modelo'] ?? '';
    $placas = $data['placas'] ?? '';
    $tipoVehiculo = $data['tipoVehiculo'] ?? '';
    $color = $data['color'] ?? '';
    $contenedor1 = $data['contenedor1'] ?? '';
    $contenedor2 = $data['contenedor2'] ?? '';

    $sql = "INSERT INTO accesos_vehiculos (marca, modelo, placas, tipo_vehiculo, color, contenedor1, contenedor2) 
            VALUES ('$marca', '$modelo', '$placas', '$tipoVehiculo', '$color', '$contenedor1', '$contenedor2')";

    if ($cn->query($sql) === TRUE) {
        echo json_encode(["mensaje" => "Datos guardados exitosamente"]);
    } else {
        echo json_encode(["error" => "Error al guardar los datos: " . $cn->error]);
    }

    $cn->close();
} else {
    echo json_encode(["error" => "No se recibieron datos"]);
}
?>
