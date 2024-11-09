<?php

function validateRequiredFields(array $data): array
{
  $required_fields = [
    'nombre_empresa_visitante',
    'tipo_movimiento',
    'fecha_entrada',
    'tipo_identificacion',
    'areas',
    'motivo',
    'usuario_creacion',
    'fecha_creacion',
    'estado_acceso',
    'id_empresa_visitada',
    'nombre_visitante',
    'estado_visitante',
    'tipo_vehiculo',
    'placas',
    'contenedor1',
    'contenedor2',
  ];

  $missing_fields = [];
  foreach ($required_fields as $field) {
    if (!array_key_exists($field, $data)) {
      $missing_fields[] = $field;
    }
  }

  if (count($missing_fields) > 0) {
    return [
      'success' => false,
      'message' => 'Campos requeridos faltantes' . implode(', ', $missing_fields),
    ];
  }

  return ['success' => true];
}

