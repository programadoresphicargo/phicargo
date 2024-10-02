<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

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

// Obtener el parámetro week_id desde la URL
if (isset($_GET['week_id'])) {
  $week_id = $cn->real_escape_string($_GET['week_id']);

  // Consulta SQL para obtener los registros con pagos confirmados
  $sql = "SELECT 
            p.id, 
            p.client_id, 
            c.nombre AS client_name, 
            p.week_id, 
            p.monday_amount, 
            p.tuesday_amount, 
            p.wednesday_amount, 
            p.thursday_amount, 
            p.friday_amount, 
            p.saturday_amount,
            p.observations, 
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'monday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_monday_amount,
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'tuesday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_tuesday_amount,
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'wednesday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_wednesday_amount,
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'thursday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_thursday_amount,
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'friday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_friday_amount,
            COALESCE(SUM(CASE WHEN apc.day_of_week = 'saturday' AND apc.confirmed THEN apc.amount ELSE 0 END), 0) AS confirmed_saturday_amount,
            COALESCE(SUM(CASE 
                            WHEN apc.day_of_week = 'monday' AND apc.confirmed THEN apc.amount
                            WHEN apc.day_of_week = 'tuesday' AND apc.confirmed THEN apc.amount
                            WHEN apc.day_of_week = 'wednesday' AND apc.confirmed THEN apc.amount
                            WHEN apc.day_of_week = 'thursday' AND apc.confirmed THEN apc.amount
                            WHEN apc.day_of_week = 'friday' AND apc.confirmed THEN apc.amount
                            WHEN apc.day_of_week = 'saturday' AND apc.confirmed THEN apc.amount
                            ELSE 0
                          END), 0) AS total_confirmed_amount
          FROM 
            accounting_weekly_collect p
          JOIN 
            clientes c ON p.client_id = c.id
          LEFT JOIN 
            accounting_collect_confirmations apc ON p.id = apc.collect_id
          WHERE 
            p.week_id = '$week_id'
          GROUP BY 
            p.id, p.client_id, c.nombre, p.week_id, p.monday_amount, p.tuesday_amount, p.wednesday_amount, 
            p.thursday_amount, p.friday_amount, p.saturday_amount, p.observations;";

  $result = $cn->query($sql);

  if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
      $row['monday_amount'] = [
        'amount' => (float) $row['monday_amount'],
        'confirmed' => (float) $row['confirmed_monday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_monday_amount'] > 0 ? (float) $row['confirmed_monday_amount'] : 0,
      ];
      $row['tuesday_amount'] = [
        'amount' => (float) $row['tuesday_amount'],
        'confirmed' => (float) $row['confirmed_tuesday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_tuesday_amount'] > 0 ? (float) $row['confirmed_tuesday_amount'] : 0,
      ];
      $row['wednesday_amount'] = [
        'amount' => (float) $row['wednesday_amount'],
        'confirmed' => (float) $row['confirmed_wednesday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_wednesday_amount'] > 0 ? (float) $row['confirmed_wednesday_amount'] : 0,
      ];
      $row['thursday_amount'] = [
        'amount' => (float) $row['thursday_amount'],
        'confirmed' => (float) $row['confirmed_thursday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_thursday_amount'] > 0 ? (float) $row['confirmed_thursday_amount'] : 0,
      ];
      $row['friday_amount'] = [
        'amount' => (float) $row['friday_amount'],
        'confirmed' => (float) $row['confirmed_friday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_friday_amount'] > 0 ? (float) $row['confirmed_friday_amount'] : 0,
      ];
      $row['saturday_amount'] = [
        'amount' => (float) $row['saturday_amount'],
        'confirmed' => (float) $row['confirmed_saturday_amount'] > 0,
        'real_amount' => (float) $row['confirmed_saturday_amount'] > 0 ? (float) $row['confirmed_saturday_amount'] : 0,
      ];
      $row['total_confirmed_amount'] = (float) $row['total_confirmed_amount'];

      unset($row['confirmed_monday_amount']);
      unset($row['confirmed_tuesday_amount']);
      unset($row['confirmed_wednesday_amount']);
      unset($row['confirmed_thursday_amount']);
      unset($row['confirmed_friday_amount']);
      unset($row['confirmed_saturday_amount']);

      $data[] = $row;
    }

    // Respuesta exitosa con código 200
    http_response_code(200);
    echo json_encode($data);
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
