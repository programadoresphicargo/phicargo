<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = intval($_POST['id_solicitud']);
$result = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'action_approve', array(array($id_solicitud)));
if ($result) {
    print_r($result);
    echo 'Waybill approved successfully.';
} else {
    die('Approval failed.');
}
