<?php
require_once '../venv.php';
require_once '../services/get_unit_state_data.php';

class ReportModel
{
  private PDO|null $cn;

  public function __construct(PDO $cn = null)
  {
    $this->cn = $cn;
    if (!$this->cn) {
      throw new Exception("No se pudo conectar a la base de datos");
    }
  }

  public function getRecordById(int $id)
  {
    $sql = "SELECT * FROM public.daily_operations_report WHERE id = :id";
    $stmt = $this->cn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  private function getRecordsByMonth(string $start_date, string $end_date)
  {
    $query = "SELECT
                id,
                date,
                simple_load,
                full_load,
                meta,
                difference,
                accumulated_difference,
                available_units,
                unloading_units,
                long_trip_units,
                units_in_maintenance,
                units_no_operator,
                total_units,
                observations,
                created_at
              FROM
                public.daily_operations_report
              WHERE
                date BETWEEN ? AND ?
              ORDER BY date ASC;";

    $stmt = $this->cn->prepare($query);
    $stmt->execute([$start_date, $end_date]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function insertMissingRecords(array $existingRecords, string $start_date)
  {
    $daysInMonth = $this->getDaysInMonth($start_date);
    $currentDate = new DateTime($start_date);

    $stats = get_units_state_data($this->cn, 1);

    for ($i = 1; $i <= $daysInMonth; $i++) {
      $formattedDate = $currentDate->format('Y-m-d');

      $recordExists = false;
      foreach ($existingRecords as $record) {
        if ($record['date'] === $formattedDate) {
          $recordExists = true;
          break;
        }
      }

      if (!$recordExists) {
        // Combinar la fecha con los datos de estado
        $newRecord = array_merge(['date' => $formattedDate], $stats);

        $this->insertRecord($newRecord);
      }

      $currentDate->modify('+1 day');
    }
  }

  public function getOrCreateRecordsByMonth(string $start_date, string $end_date)
  {
    $existingRecords = $this->getRecordsByMonth($start_date, $end_date);

    if (count($existingRecords) === $this->getDaysInMonth($start_date)) {
      return $existingRecords;
    }

    $this->insertMissingRecords($existingRecords, $start_date);

    return $this->getRecordsByMonth($start_date, $end_date);
  }

  // Función para obtener el número de días en el mes del rango dado
  private function getDaysInMonth(string $date)
  {
    $dt = new DateTime($date);
    return $dt->format('t'); // Devuelve el número de días en el mes
  }

  public function insertRecord(array $data)
  {
    $query = "INSERT INTO public.daily_operations_report(
	              date, simple_load, full_load, meta, difference, accumulated_difference, 
                available_units,  unloading_units, long_trip_units, units_in_maintenance, 
                units_no_operator, total_units, observations)
	            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    if (!$stmt) {
      throw new Exception("Error al preparar la consulta");
    }

    $result = $stmt->execute([
      $data['date'],
      $data['simple_load'],
      $data['full_load'],
      $data['meta'],
      $data['difference'],
      $data['accumulated_difference'],
      $data['available_units'],
      $data['unloading_units'],
      $data['long_trip_units'],
      $data['units_in_maintenance'],
      $data['units_no_operator'],
      $data['total_units'],
      $data['observations'],
    ]);

    if (!$result) {
      throw new Exception("Error al insertar el registro");
    }
  }

  public function updateRecord(int $id, array $data)
  {
    $set_clause = [];
    foreach ($data as $field => $value) {
      $set_clause[] = "$field = :$field";
    }
    $set_clause_str = implode(", ", $set_clause);

    $sql = "UPDATE public.daily_operations_report SET $set_clause_str WHERE id = :id";
    $stmt = $this->cn->prepare($sql);

    foreach ($data as $field => $value) {
      $stmt->bindValue(":$field", $value);
    }
    $stmt->bindValue(":id", $id);

    if ($stmt->execute()) {
      return $this->getRecordById($id);
    } else {
      throw new Exception("No se pudo actualizar el registro.");
    }
  }

  public function __destruct()
  {
    $this->cn = null;
  }
}
