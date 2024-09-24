<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';


$cn = conectar_pg();

if (!$cn) {
  echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
  exit;
}

try {
  $query = "SELECT
	            FV.ID,
	            FV.NAME2,
	            FV.X_TIPO_VEHICULO,
	            FV.FLEET_TYPE,
	            RS.ID AS STORE_ID,
	            RS.CODE AS STORE_CODE,
	            RS.NAME AS STORE_NAME
            FROM
	            PUBLIC.FLEET_VEHICLE FV
	          LEFT JOIN PUBLIC.RES_STORE RS ON FV.X_SUCURSAL = RS.ID
            WHERE
	            FV.ACTIVE = TRUE
	            AND FV.VEHICLE_TYPE_ID = 2162
	            AND FV.SUPPLIER_VEHICLE != TRUE;";

  $stmt = $cn->prepare($query);
  $stmt->execute();

  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Reestructurar el resultado para que x_sucursal sea un JSON con id, code y name
  $resultado = array_map(function($row) {
    return [
      'id' => $row['id'],
      'name2' => $row['name2'],
      'x_tipo_vehiculo' => $row['x_tipo_vehiculo'],
      'x_sucursal' => [
        'id' => $row['store_id'],
        'code' => $row['store_code'],
        'name' => $row['store_name']
      ]
    ];
  }, $datos);

  echo json_encode($resultado);

} catch (PDOException $e) {
  echo json_encode(["error" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

$cn = null;
