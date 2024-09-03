<?php
require_once('../../../mysql/conexion.php');

$cn = conectar();
$viaje_id = $_POST['viaje_id'];
$tipo_checklist = 'firma_' . $_POST['tipo_checklist'];

$sql = "SELECT * FROM checklist_evidencias where viaje_id = $viaje_id and tipo_checklist = '$tipo_checklist'";
$resultado = $cn->query($sql);
if ($resultado->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
