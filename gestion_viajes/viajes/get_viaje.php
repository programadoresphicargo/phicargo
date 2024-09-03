<?php
require_once('../../odoo/odoo-conexion.php');

if (!empty($uid)) {
    $partners = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.travel',
        'search_read',
        array(
            array(
                array('id', '=', 61481),
            )
        ),
        ['order' => 'name desc', 'limit' => 2]
    );
    header('Content-Type: application/json');
    echo json_encode($partners);
} else {
    echo "Failed to sign in";
}
