<?php

require_once('../../base_path.php');

require_once(BASE_PATH . '/ripcord-master/ripcord.php');

function get_providers_names(array $provider_ids): array
{
  try {
    // Leer el archivo de configuración
    $Datos = file_get_contents('/var/www/html/ajustes/configuraciones/GuardarCredencialesOdooCorreo.json');
    if ($Datos === false) {
      throw new Exception("No se pudo leer el archivo de configuración.");
    }

    // Decodificar el JSON
    $decoded_json = json_decode($Datos, true);
    if ($decoded_json === null) {
      throw new Exception("Error al decodificar el JSON.");
    }

    // Obtener credenciales
    $url = $decoded_json[0];
    $username = $decoded_json[1];
    $password = $decoded_json[2];
    $db = $decoded_json[3];

    // Inicializar clientes
    $common = ripcord::client("$url/xmlrpc/2/common");
    $uid = $common->authenticate($db, $username, $password, array());
    if (!$uid) {
      throw new Exception("Autenticación fallida.");
    }

    $models = ripcord::client("$url/xmlrpc/2/object");

    // Consultar proveedores en batch
    $providers = $models->execute_kw(
      $db,
      $uid,
      $password,
      'res.partner',
      'read',
      array($provider_ids),
      array('fields' => array('id', 'name'))
    );

    // Mapear los nombres de los proveedores
    $provider_map = [];
    foreach ($providers as $provider) {
      $provider_map[$provider['id']] = $provider['name'];
    }

    return $provider_map;
  } catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    return [];
  }
}

// Función para obtener todos los proveedores desde Odoo
function get_providers(): array
{
  try {
    // Leer el archivo de configuración
    $Datos = file_get_contents(BASE_PATH . '/ajustes/configuraciones/GuardarCredencialesOdooCorreo.json');
    if ($Datos === false) {
      throw new Exception("No se pudo leer el archivo de configuración.");
    }

    // Decodificar el JSON
    $decoded_json = json_decode($Datos, true);
    if ($decoded_json === null) {
      throw new Exception("Error al decodificar el JSON.");
    }

    // Obtener credenciales
    $url = $decoded_json[0];
    $username = $decoded_json[1];
    $password = $decoded_json[2];
    $db = $decoded_json[3];

    // Inicializar clientes
    $common = ripcord::client("$url/xmlrpc/2/common");
    $uid = $common->authenticate($db, $username, $password, array());
    if (!$uid) {
      throw new Exception("Autenticación fallida.");
    }

    $models = ripcord::client("$url/xmlrpc/2/object");

    // Consultar todos los proveedores (o una paginación si hay muchos)
    $providers = $models->execute_kw(
      $db,
      $uid,
      $password,
      'res.partner',
      'search_read',
      array(
        array(
          array('supplier', '=', true),
          array('active', '=', true),
        )
      ),
      array('fields' => array('name'))
    );

    return $providers;
  } catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    return [];
  }
}
