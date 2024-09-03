<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$mesActual = date('m');

if (isset($_POST['referencia'])) {
    $referencia = $_POST['referencia'];
} else {
    $referencia = '';
}

if (isset($_POST['operador'])) {
    $operador = $_POST['operador'];
} else {
    $operador = '';
}

if (isset($_POST['unidad'])) {
    $unidad = $_POST['unidad'];
} else {
    $unidad = '';
}

if (isset($_POST['contenedor'])) {
    $contenedor = $_POST['contenedor'];
} else {
    $contenedor = '';
}

$estado = $_POST['estado'];

$estados = array();

if ($estado) {
    $estados[] = $estado;
}

$sql = "SELECT *, viajes.id as travel_id, viajes.estado as est FROM viajes inner join operadores on operadores.id = viajes.employee_id inner join unidades on unidades.placas = viajes.placas where unidad like '%$unidad%' and nombre_operador like '%$operador%' and viajes.estado IN ('" . implode("', '", $estados) . "') and referencia like '%$referencia%' and month(date_order) IN ($mesActual) order by date_order desc";
$result = $cn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo $json_data = json_encode($data);
} else {
    echo "No se encontraron resultados.";
}
