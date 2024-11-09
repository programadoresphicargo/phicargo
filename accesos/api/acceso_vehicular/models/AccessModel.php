<?php
require_once '../../venv.php';

class AccessModel
{
  private mysqli|null $cn;

  public function __construct(mysqli $cn = null)
  {
    $this->cn = $cn;
    if (!$this->cn) {
      throw new Exception("No se pudo conectar a la base de datos");
    }
  }

  private function create_company_access(string $company_name, int $user_id)
  {
    $query = "INSERT INTO empresas_accesos(
                nombre_empresa, id_usuario, fecha_hora
              ) VALUES (?, ?, ?);";

    $date = date('Y-m-d H:i:s');

    $stmt = $this->cn->prepare($query);

    if (!$stmt) {
      throw new Exception("Error al preparar la consulta: " . $this->cn->error);
    }

    $stmt->bind_param('sis', $company_name, $user_id, $date);

    if (!$stmt->execute()) {
      throw new Exception("Error al crear empresa de visita: " . $stmt->error);
    }

    $stmt->close();

    return $this->cn->insert_id;
  }

  private function create_access(array $data, int $id_empresa)
  {
    $query = "INSERT INTO accesos(
                id_empresa, tipo_movimiento, fecha_entrada, tipo_identificacion,
                areas, motivo, usuario_creacion, fecha_creacion, estado_acceso, id_empresa_visitada)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    $stmt->bind_param(
      'isssssissi',
      $id_empresa,
      $data['tipo_movimiento'],
      $data['fecha_entrada'],
      $data['tipo_identificacion'],
      $data['areas'],
      $data['motivo'],
      $data['usuario_creacion'],
      $data['fecha_creacion'],
      $data['estado_acceso'],
      $data['id_empresa_visitada'],
    );

    if (!$stmt->execute()) {
      throw new Exception("Error al crear acceso: " . $stmt->error);
    }

    $stmt->close();

    return $this->cn->insert_id;
  }

  private function create_visitor(array $data, int $id_empresa)
  {
    $query = "INSERT INTO visitantes(
                id_empresa, nombre_visitante, id_usuario, fecha_hora, estado_visitante
              ) VALUES (?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    $date = date('Y-m-d H:i:s');

    $stmt->bind_param(
      'isisi', 
      $id_empresa,
      $data['nombre_visitante'], 
      $data['usuario_creacion'], 
      $date, 
      $data['estado_visitante']
    );

    if (!$stmt->execute()) {
      throw new Exception("Error al crear visitante: " . $stmt->error);
    }

    $stmt->close();

    return $this->cn->insert_id;
  }

  private function create_access_vitor(int $id_acceso, int $id_visitante)
  {
    $query = "INSERT INTO acceso_visitante(
                id_acceso, id_visitante
              ) VALUES (?, ?);";

    $stmt = $this->cn->prepare($query);

    $stmt->bind_param('ii', $id_acceso, $id_visitante);

    if (!$stmt->execute()) {
      throw new Exception("Error al crear acceso visitante: " . $stmt->error);
    }

    $stmt->close();

    return true;
  }

  private function create_vehicle(array $data)
  {
    $query = "INSERT INTO vehiculos(
                tipo_vehiculo, placas, contenedor1, contenedor2, usuario_creacion, fecha_creacion
              ) VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    $date = date('Y-m-d H:i:s');

    $stmt->bind_param(
      'ssssis',
      $data['tipo_vehiculo'],
      $data['placas'],
      $data['contenedor1'],
      $data['contenedor2'],
      $data['usuario_creacion'],
      $date
    );

    if (!$stmt->execute()) {
      throw new Exception("Error al crear vehículo: " . $stmt->error);
    }

    $stmt->close();

    return $this->cn->insert_id;
  }

  private function create_access_vehicle(int $id_acceso, int $id_vehicle)
  {
    $query = "INSERT INTO acceso_vehicular(
                id_acceso, id_vehiculo
              ) VALUES (?, ?);";

    $stmt = $this->cn->prepare($query);

    $stmt->bind_param('ii', $id_acceso, $id_vehicle);

    if (!$stmt->execute()) {
      throw new Exception("Error al crear acceso vehículo: " . $stmt->error);
    }

    $stmt->close();

    return true;
  }

  public function insert_access(array $data)
  {
    $user_id = intval($data['usuario_creacion']);
    $company_name = $data['nombre_empresa_visitante'];
    
    try {
      // Crear empressa de visita 
      $id_empresa = $this->create_company_access($company_name, $user_id);
      
      // Crear acceso
      $id_acceso = $this->create_access($data, $id_empresa);
      
      // Crear visitante
      $id_visitante = $this->create_visitor($data, $id_empresa);
      
      // Crear acceso de visitante
      $this->create_access_vitor($id_acceso, $id_visitante);
      
      // Crear vehículo
      $id_vehicle = $this->create_vehicle($data);
      
      // Crear acceso de vehículo
      $this->create_access_vehicle($id_acceso, $id_vehicle);

    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }

  }

  public function __destruct()
  {
    $this->cn->close();
  }
}