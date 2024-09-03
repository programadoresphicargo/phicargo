<?php
require_once('../../mysql/conexion.php');
require_once('../../envio_correos/sistemas/sistemas.php');

$cn = conectar();
$fechaActual = date('Y-m-d H:i:s');
$id_operador = $_POST['id_operador'];
$notas_operador = $_POST['notas_operador'];
$SQL = "INSERT INTO reportes_app VALUES(NULL,$id_operador,'$notas_operador','$fechaActual','revision', null, null, null)";
if ($cn->query($SQL)) {

    $id_insertado = $cn->insert_id;
    enviar_reporte_fallas_correo($id_insertado);
    $images = json_decode($_POST['images']);

    foreach ($images as $image) {
        $SQL = "INSERT INTO files VALUES(NULL,'$image', $id_insertado ,'reportes_app')";
        $cn->query($SQL);
    }

    echo 1;
} else {
    echo 0;
}
