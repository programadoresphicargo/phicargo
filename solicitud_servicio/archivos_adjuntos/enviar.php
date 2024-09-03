<?php
require_once('../../odoo/odoo-conexion.php');

session_name('phicargocliente');
session_start();
$id_solicitud = $_POST['id_solicitud'];
$usuario = $_SESSION['userID'];

if (!empty($_FILES['files'])) {
    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['files']['name'][$key];
        $fileTempPath = $_FILES['files']['tmp_name'][$key];

        $fileContent = base64_encode(file_get_contents($fileTempPath));

        $values = array(
            'name' => $fileName,
            'datas' => $fileContent,
            'datas_fname' => $fileName,
            'res_model' => 'tms.waybill',
            'res_id' => $id_solicitud,
        );

        $partners = $models->execute_kw($db, $uid, $password, 'ir.attachment', 'create', array($values));
        print_r($partners);
    }
}
