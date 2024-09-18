<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Indicar que la respuesta es JSON

require_once('../../base_path.php');

session_start();
if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

// Leer los datos de la solicitud POST (asumiendo que vienen en formato JSON)
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['client_id']) && 
    isset($data['week_id'])) {

    // Variables obtenidas desde la solicitud
    $client_id = $cn->real_escape_string($data['client_id']);
    $week_id = $cn->real_escape_string($data['week_id']);

    // Monto opcional para cada día (puedes validar cada día de manera opcional)
    $monday_amount = isset($data['monday_amount']) ? $cn->real_escape_string($data['monday_amount']) : 0;
    $tuesday_amount = isset($data['tuesday_amount']) ? $cn->real_escape_string($data['tuesday_amount']) : 0;
    $wednesday_amount = isset($data['wednesday_amount']) ? $cn->real_escape_string($data['wednesday_amount']) : 0;
    $thursday_amount = isset($data['thursday_amount']) ? $cn->real_escape_string($data['thursday_amount']) : 0;
    $friday_amount = isset($data['friday_amount']) ? $cn->real_escape_string($data['friday_amount']) : 0;
    $saturday_amount = isset($data['saturday_amount']) ? $cn->real_escape_string($data['saturday_amount']) : 0;

    // Consulta SQL para insertar el registro
    $sql = "INSERT INTO accounting_weekly_collect 
            ( client_id, 
              week_id, 
              monday_amount, 
              tuesday_amount, 
              wednesday_amount, 
              thursday_amount, 
              friday_amount, 
              saturday_amount)
            VALUES (
              '$client_id', 
              '$week_id', 
              '$monday_amount', 
              '$tuesday_amount', 
              '$wednesday_amount', 
              '$thursday_amount', 
              '$friday_amount', 
              '$saturday_amount')";

    // Ejecutar la consulta
    if ($cn->query($sql) === TRUE) {
        // Respuesta exitosa
        echo json_encode([
            "success" => true,
            "message" => "Registro insertado exitosamente"
        ]);
    } else {
        // Respuesta de error en caso de fallo en la consulta
        echo json_encode([
            "success" => false,
            "message" => "Error al insertar el registro: " . $cn->error
        ]);
    }
} else {
    // Respuesta de error si faltan campos obligatorios
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos obligatorios (client_id, week_id o projection)"
    ]);
}

// Cierra la conexión a la base de datos
$cn->close();

