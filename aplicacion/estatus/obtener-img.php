<?php

require_once('../../odoo/odoo-conexion.php');

$referencia = $_POST['referencia'];

$ids = $models->execute_kw($db, $uid, $password, 'ir.attachment', 'search_read', array(array(array('res_name', '=', $referencia),),), array(
    'fields' => array('datas'),
));

$json = json_encode($ids);
print($json);
