<?php

function get_collect_register_by_id(mysqli $cn, int $id)
{
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
                                WHEN apc.confirmed THEN apc.amount
                                ELSE 0
                              END), 0) AS total_confirmed_amount
            FROM 
                accounting_weekly_collect p
            JOIN 
                clientes c ON p.client_id = c.id
            LEFT JOIN 
                accounting_collect_confirmations apc ON p.id = apc.collect_id
            WHERE 
                p.id = ?
            GROUP BY 
                p.id, p.client_id, c.nombre, p.week_id, p.monday_amount, p.tuesday_amount, p.wednesday_amount, 
                p.thursday_amount, p.friday_amount, p.saturday_amount, p.observations;";

  // Preparar la sentencia
  $stmt = $cn->prepare($sql);
  if (!$stmt) {
    throw new Exception("Error al preparar la consulta: " . $cn->error);
  }

  // Bind del parámetro $id
  $stmt->bind_param("i", $id);

  // Ejecutar la consulta
  $stmt->execute();

  // Obtener los resultados
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $data = [];

    // Función para procesar los días y reducir redundancia
    function processDayAmount($row, $day)
    {
      return [
        'amount' => (float) $row["{$day}_amount"],
        'confirmed' => (float) $row["confirmed_{$day}_amount"] > 0,
        'real_amount' => (float) $row["confirmed_{$day}_amount"] > 0 ? (float) $row["confirmed_{$day}_amount"] : 0,
      ];
    }

    while ($row = $result->fetch_assoc()) {
      $row['monday_amount'] = processDayAmount($row, 'monday');
      $row['tuesday_amount'] = processDayAmount($row, 'tuesday');
      $row['wednesday_amount'] = processDayAmount($row, 'wednesday');
      $row['thursday_amount'] = processDayAmount($row, 'thursday');
      $row['friday_amount'] = processDayAmount($row, 'friday');
      $row['saturday_amount'] = processDayAmount($row, 'saturday');
      $row['total_confirmed_amount'] = (float) $row['total_confirmed_amount'];

      // Limpiar las columnas no necesarias del resultado final
      unset($row['confirmed_monday_amount']);
      unset($row['confirmed_tuesday_amount']);
      unset($row['confirmed_wednesday_amount']);
      unset($row['confirmed_thursday_amount']);
      unset($row['confirmed_friday_amount']);
      unset($row['confirmed_saturday_amount']);

      $data[] = $row;
    }

    return $data[0];
  } else {
    return null;
  }
}