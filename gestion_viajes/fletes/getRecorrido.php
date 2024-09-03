<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sqlSelect = "SELECT latitud, longitud
FROM reportes_estatus_viajes
inner join ubicaciones_estatus on ubicaciones_estatus.id_ubicacion = reportes_estatus_viajes.id_ubicacion
WHERE id_viaje = $id_viaje";
$resultado = $cn->query($sqlSelect);
while ($row = $resultado->fetch_assoc()) {

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            if ($row['latitud'] != 0.0 && $row['latitud'] != 0.0) {
                $array['coordenadas1'][] = array(
                    $row["latitud"],
                    $row["longitud"]
                );
            }
        }
    }
}

echo json_encode($array);
