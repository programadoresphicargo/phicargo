<?php
require_once('../../mysql/conexion.php');
require_once('../codigos/getContenedores.php');
$cn = conectar();

if (isset($_GET['estado_maniobra'])) {
    $estado_maniobra = $_GET['estado_maniobra'];
    $unidad = '';
} else {
    $estado_maniobra = $_POST['estado_maniobra'];
    $unidad = $_POST['unidad'];
}

$sql = "SELECT *,
GROUP_CONCAT(maniobra_contenedores.id_cp ORDER BY maniobra_contenedores.id_cp SEPARATOR ',') AS contenedores_ids
FROM maniobra
inner join flota on flota.vehicle_id = maniobra.vehicle_id
inner join operadores on operadores.id = maniobra.operador_id
LEFT JOIN maniobra_contenedores ON maniobra_contenedores.id_maniobra = maniobra.id_maniobra
where estado_maniobra = '$estado_maniobra' 
and maniobra.vehicle_id like '%$unidad%'
group by maniobra.id_maniobra";
$resultado = $cn->query($sql);
if ($resultado->num_rows > 0) {
    $data = array();
    while ($row = $resultado->fetch_assoc()) {
        $array_ids = explode(',', $row['contenedores_ids']);
        foreach ($array_ids as $id) {
            $contenedor_data = contenedor($id);
            foreach ($contenedor_data as $item) {
                $contenedor = $item['x_reference'];
                $row['contenedor'] = $contenedor;
            }
        }
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
