<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = intval($_POST['id_solicitud']);
$result = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'copy', array(array($id_solicitud)));
print_r($result);
