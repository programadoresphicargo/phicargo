<?php
require_once '../venv.php';

class UnitModel
{
  private PDO|null $cn;

  public function __construct(PDO $cn = null)
  {
    $this->cn = $cn;
    if (!$this->cn) {
      throw new Exception("No se pudo conectar a la base de datos");
    }
  }

  /**
   * Obtiene los registros de unidades 
   * @return array
   *  - total_units: int
   *  - units_in_maintenance: int
   *  - units_no_operator: int
   * @throws \Exception
   */
  public function getUnitIndicators(int $branchId)
  {
    // Definimos la consulta con marcadores de posición para los parámetros
    $query = "SELECT
                  COUNT(*) AS total_units,
                  COUNT(*) FILTER (WHERE FVS.ID = 5) AS units_in_maintenance,
                  COUNT(*) FILTER (WHERE FV.X_OPERADOR_ASIGNADO IS NULL) AS units_no_operator  
                FROM
                  PUBLIC.FLEET_VEHICLE FV
                  LEFT JOIN PUBLIC.RES_STORE RS ON FV.X_SUCURSAL = RS.ID
                  LEFT JOIN PUBLIC.FLEET_VEHICLE_STATE FVS ON FV.STATE_ID = FVS.ID
                WHERE
                  FV.ACTIVE = TRUE
                  AND FV.VEHICLE_TYPE_ID = 2162 
                  AND FV.X_TIPO_VEHICULO = 'carretera'
                  AND FV.X_SUCURSAL = :branchId
                  AND FV.SUPPLIER_VEHICLE != TRUE";

    // Preparamos la consulta
    $stmt = $this->cn->prepare($query);

    $stmt->bindParam(':branchId', $branchId, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  public function __destruct()
  {
    $this->cn = null;
  }
}
