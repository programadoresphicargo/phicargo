<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT *, 
viajes.estado AS estado_viaje, 
viajes.id AS id_viaje
FROM viajes 
left join operadores on operadores.id = viajes.employee_id
left join unidades on unidades.placas = viajes.placas
where viajes.estado IN ('ruta','planta')
order by estado_viaje desc";
$resultado = $cn->query($sql);

if ($resultado->num_rows > 0) {
    $datos = array();
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }

    echo json_encode($datos);
} else {
    echo json_encode(array());
}
