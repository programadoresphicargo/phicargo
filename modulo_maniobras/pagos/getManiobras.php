<?php
require_once('getManiobrasOperador.php');

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$operador_id = $data['operador_id'];
$periodo_inicio = $data['periodo_inicio'];
$periodo_fin = $data['periodo_fin'];

$resultados = obtenerManiobras($operador_id, $periodo_inicio, $periodo_fin);
echo json_encode($resultados);
