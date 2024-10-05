<?php

function edit_vehicle_status(PDO $cn, int $tract_id, int $status_id): bool
{
  try {
    $updateTruckQuery = "UPDATE public.fleet_vehicle SET state_id = ? WHERE id = ?";
    $updateStmt = $cn->prepare($updateTruckQuery);

    $updateResult = $updateStmt->execute([$status_id, $tract_id]);

    if ($updateResult && $updateStmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  } catch (PDOException $e) {
    error_log("Error al actualizar el estado del vehículo: " . $e->getMessage());
    return false;
  }
}
