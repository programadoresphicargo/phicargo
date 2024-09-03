<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');
$cn = conectar();

$domain = [
    ['active', '=', true]
];
$kwargs = ['order' => 'id desc', 'domain' => $domain, 'fields' => ['name', 'department_id', 'job_id']];
$partners = $models->execute_kw($db, $uid, $password, 'hr.employee', 'search_read', [], $kwargs);
$json = json_encode($partners, JSON_PRETTY_PRINT);

$decoded_json = json_decode($json, true);

foreach ($decoded_json as $partner) {
    $id = $partner['id'];
    $name = $partner['name'];
    $job_id = $partner['job_id'][0];
    $job_id_name = $partner['job_id'][1];

    try {
        $sql = "INSERT INTO empleados VALUES ($id, '$name', $job_id, '$job_id_name')";
        $cn->query($sql);
    } catch (Exception $e) {
        echo ("Error inserting record with ID $id: " . $e->getMessage());
    }
}
