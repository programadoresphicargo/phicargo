<?php
function validateRequiredFields(array $data, array $required_fields)
{
  foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
      return ["success" => false, "message" => "Campo faltante: $field"];
    }
  }
  return ["success" => true];
}