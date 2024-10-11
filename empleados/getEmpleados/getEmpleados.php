<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');
$cn = conectar();

$domain = [
    ['active', '=', true]
];
$kwargs = ['order' => 'id desc', 'domain' => $domain, 'fields' => ['name', 'department_id', 'job_id']];
$partners = $models->execute_kw($db, $uid, $password, 'hr.employee', 'search_read', [], $kwargs);
echo $json = json_encode($partners, JSON_PRETTY_PRINT);