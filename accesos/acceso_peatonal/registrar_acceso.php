<?php
require_once('../../mysql/conexion.php');

session_start();
$id_usuario = $_SESSION['userID'];
$listaJSON = $_POST['lugares'];
$opcionesSeleccionadas = json_encode($listaJSON, true);
$visitantes = $_POST['visitantes'];

$datos = $_POST['datos'];
parse_str($datos, $datosF);

$fechaHoraActual = date("Y-m-d H:i:s");
$tipo_mov = $datosF['tipo_mov'];
$fecha_entrada = $datosF['fecha_entrada'];
$empresa = $datosF['empresa'];
$tipo_identificacion = $datosF['tipo_identificacion'];
$motivo = $datosF['motivo'];

$cn = conectar();
$sql = "INSERT INTO acceso_peatonal VALUES(NULL,'$tipo_mov','$fecha_entrada','$tipo_identificacion',$empresa,$opcionesSeleccionadas,'$motivo',$id_usuario,'$fechaHoraActual','espera',null,null,null,null)";
if ($cn->query($sql)) {
    $id_insertado = $cn->insert_id;
    $respuesta = array('status' => 1, 'id_insertado' => $id_insertado);
    echo json_encode($respuesta);

    foreach ($visitantes as $visitante) {
        $id = $visitante['id'];
        $sql = "INSERT INTO registro_visitantes VALUES(NULL,$id_insertado,$id)";
        $cn->query($sql);
    }
} else {
    $respuesta = array('status' => 0, 'error' => $cn->error);
    echo json_encode($respuesta);
}
