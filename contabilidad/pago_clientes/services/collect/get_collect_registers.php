<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once('../../base_path.php');

require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

// Obtener el parámetro week_id desde la URL
if (isset($_GET['week_id'])) {
    $week_id = $cn->real_escape_string($_GET['week_id']);
    
    $sql = "SELECT p.id, p.client_id, c.nombre AS client_name, p.week_id, 
                   p.monday_amount, p.tuesday_amount, p.wednesday_amount, 
                   p.thursday_amount, p.friday_amount, p.saturday_amount,
                   p.observations, p.projection
            FROM accounting_weekly_collect p
            JOIN clientes c ON p.client_id = c.id
            WHERE p.week_id = '$week_id'";
    
    $result = $cn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            // Convertir los valores a los tipos adecuados
            $row['week_id'] = (int)$row['week_id'];
            $row['monday_amount'] = (float)$row['monday_amount'];
            $row['tuesday_amount'] = (float)$row['tuesday_amount'];
            $row['wednesday_amount'] = (float)$row['wednesday_amount'];
            $row['thursday_amount'] = (float)$row['thursday_amount'];
            $row['friday_amount'] = (float)$row['friday_amount'];
            $row['saturday_amount'] = (float)$row['saturday_amount'];
            $row['projection'] = (float)$row['projection'];
            
            $data[] = $row;
        }

        // Respuesta exitosa con código 200
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
    } else {
        // No se encontraron registros, responder con código 404
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "No se encontraron registros para la semana especificada"
        ]);
    }
} else {
    // Faltan parámetros, responder con código 400
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Falta el parámetro week_id"
    ]);
}

// Cierra la conexión a la base de datos
$cn->close();
