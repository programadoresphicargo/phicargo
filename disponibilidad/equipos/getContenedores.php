<?php
require_once('../../odoo/odoo-conexion.php');

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

$domain[0][] = ['name', '!=', false];

$kwargs = ['fields' => ['id', 'name2', 'x_status', 'x_om', 'x_viaje', 'fleet_type', 'license_plate', 'x_maniobra']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    $domain,
    $kwargs
);

$data = json_encode($ids);
if (isset($_POST['searchResults'])) {
    echo $data;
}