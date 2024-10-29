<?php

require_once 'validate_date.php';

function get_week_id(mysqli $cn, string $start_date, string $end_date): ?int
{
  if (!validate_date($start_date) || !validate_date($end_date)) {
    return null;
  }

  try {
    $checkSql = $cn->prepare(
      "SELECT id 
             FROM accounting_weeks 
             WHERE start_date = ? 
             AND end_date = ?;"
    );

    if (!$checkSql) {
      throw new Exception("Error al preparar la consulta: " . $cn->error);
    }

    $checkSql->bind_param("ss", $start_date, $end_date);
    $checkSql->execute();
    $result = $checkSql->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return (int) $row['id'];
    }

    return null;

  } catch (Exception $e) {
    return null;

  } finally {
    if (isset($checkSql)) {
      $checkSql->close();
    }
  }
}
