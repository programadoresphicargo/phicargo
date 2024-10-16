<?php
require_once '../venv.php';

class ReportModel
{
  private PDO | null $cn;

  public function __construct(PDO $cn = null)
  {
    $this->cn = $cn;
    if (!$this->cn) {
      throw new Exception("No se pudo conectar a la base de datos");
    }
  }

  public function getRecordById(int $id)
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
                id = ?;";

    $stmt = $this->cn->prepare($query);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtiene todos los registros de la tabla de reporte diario
   * @return array
   *  - id: int
   *  - date: string
   *  - simple_load: int
   *  - full_load: int
   *  - meta: int
   *  - difference: int
   *  - accumulated_difference: int
   *  - available_units: int
   *  - unloading_units: int
   *  - long_trip_units: int
   *  - units_in_maintenance: int
   *  - units_no_operator: int
   *  - total_units: int
   *  - observations: string
   *  - created_at: string
   * @throws \Exception
   */
  public function getRecords()
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
                public.daily_operations_report;";

    $stmt = $this->cn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Inserta un registro en la tabla de reporte diario
   * @param array $data Datos a insertar
   *  - date: string
   *  - simple_load: int
   *  - full_load: int
   *  - meta: int
   *  - difference: int
   *  - accumulated_difference: int
   *  - available_units: int
   *  - unloading_units: int
   *  - long_trip_units: int
   *  - units_in_maintenance: int
   *  - units_no_operator: int
   *  - total_units: int
   *  - observatios: string
   * @throws \Exception
   * @return bool|string
   */
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

    if ($result) {
      $new_id = $this->cn->lastInsertId();
      $new_id = intval($new_id);
      $new_record = $this->getRecordById($new_id);
      return $new_record;
    } else {
      throw new Exception("Error al insertar el registro");
    }
  }

  public function __destruct()
  {
    $this->cn = null; 
  }
}