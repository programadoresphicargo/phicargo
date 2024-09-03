<?php
require_once('../../odoo/odoo-conexion.php');

$record_id = 44966;
$model = 'tms.waybill';

try {
    $new_record_id = $models->execute_kw(
        $db,
        $uid,
        $password,
        $model,
        'copy',
        [$record_id]
    );

    echo "El nuevo registro duplicado tiene el ID: " . $new_record_id . "\n";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
