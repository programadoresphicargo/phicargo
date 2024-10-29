<?php

require_once '../models/UnitModel.php';

function get_units_state_data(PDO $cn, int $branch_id)
{

  $unitModel = new UnitModel($cn);

  try {
    $unitIndicators = $unitModel->getUnitIndicators($branch_id);
    $indicators = $unitIndicators[0];

    $total_units = $indicators['total_units'];
    $units_in_maintenance = $indicators['units_in_maintenance'];
    $units_no_operator = $indicators['units_no_operator'];

    $units_state_data = [
      'simple_load' => 0,
      'full_load' => 0,
      'total' => 0,
      'meta' => 0,
      'difference' => 0,
      'accumulated_difference' => 0,
      'unloading_units' => 0,
      'long_trip_units' => 0,
      "available_units" => $total_units - ($units_in_maintenance + $units_no_operator),
      "units_in_maintenance" => $indicators['units_in_maintenance'],
      "units_no_operator" => $indicators['units_no_operator'],
      "total_units" => $indicators['total_units'],
      'observations' => '',
    ];

    return $units_state_data;
  } catch (Exception $e) {
    return ["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()];
  }

}