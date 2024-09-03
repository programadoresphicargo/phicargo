<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$kwargs2 = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'x_status_viaje', 'x_modo_bel', 'store_id', 'x_operador_bel_id', 'vehicle_id', 'route_id', 'x_date_arrival_shed', 'x_reference', 'partner_id', 'x_codigo_postal', 'x_tipo_bel', 'x_medida_bel'],  'order' => 'store_id asc, x_status_viaje desc'];

if ($_POST['consulta'] == 'activos') {
    $consulta = ['ruta', 'planta', 'retorno', false];
} else if ($_POST['consulta'] == 'finalizado') {
    $consulta = ['finalizado'];
} else if ($_POST['consulta'] == 'disponibles') {
    $consulta = [false];
} else if ($_POST['consulta'] == 'todo') {
    $consulta = ['ruta', 'planta', 'retorno', false];
} else if ($_POST['consulta'] == 'ruta') {
    $consulta = ['ruta'];
} else if ($_POST['consulta'] == 'planta') {
    $consulta = ['planta'];
} else if ($_POST['consulta'] == 'retorno') {
    $consulta = ['retorno'];
} else if ($_POST['consulta'] == 'resguardo') {
    $consulta = ['resguardo'];
}

$domain = [];

if (isset($_POST['searchResults'])) {
    $searchResultsArray = $_POST['searchResults'];
    if (isset($searchResultsArray) && !empty($searchResultsArray)) {
        $searchResultsJSON = json_encode($searchResultsArray);
        if ($searchResultsJSON !== false) {
            $decodedSearchResults = json_decode($searchResultsJSON, true);
            if ($decodedSearchResults !== null) {
                foreach ($decodedSearchResults as $result) {
                    $campoEspecifico1 = $result['texto'];
                    $campoEspecifico2 = $result['opcion'];
                    $new_condition = [$campoEspecifico2, 'ilike', $campoEspecifico1];
                    if (empty($domain[0])) {
                    } else {
                        array_unshift($domain[0], '|');
                    }
                    $domain[0][] = $new_condition;
                }
            } else {
                echo "Error al decodificar la cadena JSON.";
            }
        } else {
            echo "Error al codificar la cadena JSON.";
        }
    } else {
        echo "No se encontraron datos en \$_POST['searchResults'].";
    }
}

$domain[0][] = ['x_status_viaje', '=', ['ruta', 'planta', 'retorno', 'resguardo']];
$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs2
);

$json2 = json_encode($ids2);
file_put_contents('viajes.json', $json2);
file_put_contents('../../push/inicio_viajes/viajes.json', $json2);
