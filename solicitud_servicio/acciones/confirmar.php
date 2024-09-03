<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = intval($_POST['id_solicitud']);
$result = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'action_confirm', array(array($id_solicitud)));
if ($result !== null) {
    preg_match("/ValidationError: \('([^']*)'\)/", $result['faultString'], $matches);
    if (isset($matches[1])) {
        $errorMessage = $matches[1];
    } else {
        echo "Mensaje de error no encontrado";
    }
} else {
    die('La aprobación falló.');
}
