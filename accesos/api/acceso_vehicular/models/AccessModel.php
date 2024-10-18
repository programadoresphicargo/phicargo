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

  public function insert(array $data)
  {
    // Prepara la consulta
    $query = "INSERT INTO acceso_vehicular(
                  nombre_operador, placas, tipo_transporte, contenedor1, contenedor2, 
                  tipo_identificacion, carga_descarga, id_empresa, sellos, areas, 
                  motivo, usuario_creacion, fecha_creacion, fecha_entrada, 
                  estado_acceso, tipo_mov)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->cn->prepare($query);

    if (!$stmt) {
      throw new Exception("Error al preparar la consulta: " . $this->cn->error);
    }

    $stmt->bind_param(
      'sssssssisssissss',
      $data['nombre_operador'],
      $data['placas'],
      $data['tipo_transporte'],
      $data['contenedor1'],
      $data['contenedor2'],
      $data['tipo_identificacion'],
      $data['carga_descarga'],
      $data['id_empresa'],
      $data['sellos'],
      $data['areas'],
      $data['motivo'],
      $data['usuario_creacion'],
      $data['fecha_creacion'],
      $data['fecha_entrada'],
      $data['estado_acceso'],
      $data['tipo_mov']
    );

    if (!$stmt->execute()) {
      throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    // Cierra el statement
    $stmt->close();

    return true;
  }


  public function __destruct()
  {
    $this->cn->close();
  }
}