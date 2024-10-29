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

  private function get_records_by_month(int $branch_id, string $start_date, string $end_date)
  {
    $query = "SELECT id, date, simple_load, full_load, total, meta,
                difference, accumulated_difference, available_units, unloading_units,
                long_trip_units, units_in_maintenance, units_no_operator, total_units,
                observations, created_at, branch_id
              FROM
                public.daily_operations_report
              WHERE
                date BETWEEN ? AND ?
                AND branch_id = ?
              ORDER BY date ASC;";

    $stmt = $this->cn->prepare($query);
    $stmt->execute([$start_date, $end_date, $branch_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function insert_missing_records(int $branch_id, string $start_date)
  {
    $daysInMonth = $this->get_days_in_month($start_date);
    $currentDate = new DateTime($start_date);

    for ($i = 1; $i <= $daysInMonth; $i++) {
      $formattedDate = $currentDate->format('Y-m-d');

      try {
        $stmt = $this->cn->prepare("SELECT public.initialize_daily_report(:branchid, :report_date)");
        $stmt->bindParam(':branchid', $branch_id, PDO::PARAM_INT);
        $stmt->bindParam(':report_date', $formattedDate, PDO::PARAM_STR);
        $stmt->execute();
      } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Ya existe un registro para la fecha') !== false) {
        } else {
          throw $e;
        }
      }

      $currentDate->modify('+1 day');
    }
  }

  private function get_days_in_month(string $date)
  {
    $dt = new DateTime($date);
    return $dt->format('t'); // Devuelve el número de días en el mes
  }

  public function get_record_by_id(int $id)
  {
    $sql = "SELECT * FROM public.daily_operations_report WHERE id = :id";
    $stmt = $this->cn->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function get_or_create_records_by_month(int $branch_id, string $start_date, string $end_date)
  {
    $existingRecords = $this->get_records_by_month($branch_id, $start_date, $end_date);

    if (count($existingRecords) === $this->get_days_in_month($start_date)) {
      return $existingRecords;
    }

    $this->insert_missing_records($branch_id, $start_date);

    return $this->get_records_by_month($branch_id, $start_date, $end_date);
  }

  public function insert_record(array $data)
  {
    $query = "INSERT INTO public.daily_operations_report(
	              date, simple_load, full_load, total, meta, difference, accumulated_difference, 
                available_units,  unloading_units, long_trip_units, units_in_maintenance, 
                units_no_operator, total_units, observations)
	            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    if (!$stmt) {
      throw new Exception("Error al preparar la consulta");
    }

    $result = $stmt->execute([
      $data['date'],
      $data['simple_load'],
      $data['full_load'],
      $data['total'],
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

  public function update_record(int $id, array $data)
  {
    // Validar que la fecha del registro sea mayor o igual a la fecha actual
    $record = $this->get_record_by_id($id);
    $recordDate = new DateTime($record['date']);
    $currentDate = new DateTime();
    if ($recordDate->format('Y-m-d') < $currentDate->format('Y-m-d')) {
      throw new Exception("No se puede actualizar de días anteriores");
    }

    // Definir los valores de los campos permitidos y asignar `NULL` a los faltantes
    $params = [
      ':record_id' => $id,
      ':new_simple_load' => $data['simple_load'] ?? null,
      ':new_full_load' => $data['full_load'] ?? null,
      ':new_unloading_units' => $data['unloading_units'] ?? null,
      ':new_long_trip_units' => $data['long_trip_units'] ?? null,
    ];

    // Consulta para ejecutar la función de PostgreSQL
    $sql = "SELECT public.update_daily_report(
                :record_id,
                :new_simple_load,
                :new_full_load,
                :new_unloading_units,
                :new_long_trip_units
            );";

    try {
      $stmt = $this->cn->prepare($sql);

      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_INT);
      }

      $stmt->execute();

      return $this->get_record_by_id($id);

    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function update_units(int $branch_id, string $record_date)
  {
    $params = [
      ':branch_id' => $branch_id,
      ':record_date' => $record_date,
    ];

    // Consulta para ejecutar la función de PostgreSQL
    $sql = "SELECT public.update_unit_data_daily_report(
                :branch_id,
                :record_date
            );";

    try {
      $stmt = $this->cn->prepare($sql);

      foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
      }

      $stmt->execute();

      return true;

    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function __destruct()
  {
    $this->cn = null;
  }
}
