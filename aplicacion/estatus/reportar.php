<?php

require('../../mysql/conexion.php');
require('../../envio_correos/sistemas/sistemas.php');

date_default_timezone_set("America/Mexico_City");
$fecha = date("Y-m-d H:i:s");
$id_operador = $_POST['id'];
$cn = conectar();
$sqlInsert = "INSERT INTO reportes_app VALUES(NULL,$id_operador,'No puedo enviar status','$fecha','revision',null,null,null)";
if ($cn->query($sqlInsert)) {
    $ultimoID = $cn->insert_id;
    enviar_reporte_fallas_correo($ultimoID);
    echo 1;
} else {
    echo 0;
}
