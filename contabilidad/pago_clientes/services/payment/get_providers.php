<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../odoo/get_providers.php';

$providers = get_providers();

// Contar el número de resultados
$response = array(
  "count" => count($providers),
  "providers" => $providers
);

echo json_encode($providers);
