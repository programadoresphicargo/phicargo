<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
session_start();
// if (!isset($_SESSION['userId'])) {
//   http_response_code(401);
//   echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
//   exit;
// }

require_once('../../base_path.php');

require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

// Query parameter week_id de la URL (/get_payments.php?week_id=1)
if (isset($_GET['week_id'])) {
  $week_id = $cn->real_escape_string($_GET['week_id']);

  $sql = "SELECT p.id, p.week_id, p.provider_id, p.provider, 
                    p.monday_amount, p.tuesday_amount, p.wednesday_amount, 
                    p.thursday_amount, p.friday_amount, p.saturday_amount, 
                    p.observations, p.concept, p.projection
            FROM accounting_weekly_payment p
            WHERE p.week_id = '$week_id'";


  $result = $cn->query($sql);

  if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
      $row['id'] = (int) $row['id'];
      $row['week_id'] = (int) $row['week_id'];
      $row['provider_id'] = (int) $row['provider_id'];
      $row['monday_amount'] = (float) $row['monday_amount'];
      $row['tuesday_amount'] = (float) $row['tuesday_amount'];
      $row['wednesday_amount'] = (float) $row['wednesday_amount'];
      $row['thursday_amount'] = (float) $row['thursday_amount'];
      $row['friday_amount'] = (float) $row['friday_amount'];
      $row['saturday_amount'] = (float) $row['saturday_amount'];
      $row['projection'] = (float) $row['projection'];

      $data[] = $row;
    }

    http_response_code(200);
    echo json_encode([
      "success" => true,
      "payments" => $data
    ]);
  } else {
    http_response_code(200);
    echo json_encode([
      "success" => true,
      "payments" => []
    ]);
  }
} else {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Falta el parámetro week_id"
  ]);
}

$cn->close();
