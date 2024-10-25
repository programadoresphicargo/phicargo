<?php

require_once 'validate_date.php';

function create_week(mysqli $cn, string $start_date, string $end_date): ?int
{
  if (!validate_date($start_date) || !validate_date($end_date)) {
    return null;
  }

  try {
    $insertSql = $cn->prepare(
      "INSERT INTO accounting_weeks (start_date, end_date) VALUES (?, ?)"
    );

    if (!$insertSql) {
      throw new Exception("Error al preparar la consulta: " . $cn->error);
    }

    $insertSql->bind_param("ss", $start_date, $end_date);
    $success = $insertSql->execute();

    if (!$success) {
      throw new Exception("Error al ejecutar la consulta: " . $insertSql->error);
    }

    $week_id = $cn->insert_id;

    return $week_id;

  } catch (Exception $e) {
    error_log("Error al crear week: " . $e->getMessage());
    return null;
  } finally {
    if (isset($insertSql)) {
      $insertSql->close();
    }
  }
}

