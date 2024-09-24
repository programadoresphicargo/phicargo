<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';
require_once BASE_PATH . '/ripcord-master/ripcord.php';

$cn = conectar_pg();

if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

try {
  $status = isset($_GET['status']) ? $_GET['status'] : null;

  $query = "SELECT 
        mr.id, 
        mr.workshop, 
        mr.fail_type, 
        mr.check_in, 
        mr.check_out, 
        mr.status, 
        mr.delivery_date, 
        mr.supervisor,
        mr.comments,
        mr.order_service,
        fv.id AS tract_id, 
        fv.name2 AS tract_name, 
        fv.x_tipo_vehiculo AS tract_x_tipo_vehiculo, 
        rs.id AS store_id, 
        rs.code AS store_code, 
        rs.name AS store_name
    FROM public.maintenance_record mr
    LEFT JOIN public.fleet_vehicle fv ON mr.tract_id = fv.id 
    LEFT JOIN public.res_store rs ON fv.x_sucursal = rs.id";

  if ($status) {
    $query .= " WHERE mr.status = :status";
  }

  $stmt = $cn->prepare($query);

  if ($status) {
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
  }

  $stmt->execute();
  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $resultado = array_map(function ($row) {
    return [
      "id" => $row['id'],
      "workshop" => $row['workshop'],
      "fail_type" => $row['fail_type'],
      "check_in" => $row['check_in'],
      "check_out" => $row['check_out'],
      "status" => $row['status'],
      "delivery_date" => $row['delivery_date'],
      "supervisor" => $row['supervisor'],
      "comments" => $row['comments'],
      "order_service" => $row['order_service'],
      "tract" => [
        "id" => $row['tract_id'],
        "name2" => $row['tract_name'],
        "x_tipo_vehiculo" => $row['tract_x_tipo_vehiculo'],
        "x_sucursal" => [
          "id" => $row['store_id'],
          "code" => $row['store_code'],
          "name" => $row['store_name']
        ]
      ]
    ];
  }, $datos);

  http_response_code(200);
  echo json_encode($resultado);

} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

$cn = null;
