<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$operador_id = $_POST['operador_id'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

function contenedor($id_cp)
{
    include('../../odoo/odoo-conexion.php');
    $kwargs = ['fields' => ['id', 'x_reference', 'x_reference_2']];

    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', $id_cp))),
        $kwargs
    );

    return $ids;
}

$sql = "SELECT 
maniobra.id_maniobra,
maniobra.inicio_programado,
maniobra.terminal,
maniobra.estado_maniobra,
flota.name as unidad,
operadores.nombre_operador,
maniobra.tipo_maniobra,
maniobra.peligroso,
c.numero_contenedores,
precios_maniobra.precio,
GROUP_CONCAT(maniobra_contenedores.id_cp ORDER BY maniobra_contenedores.id_cp SEPARATOR ',') AS contenedores_ids
FROM maniobra
LEFT JOIN operadores ON operadores.id = maniobra.operador_id
LEFT JOIN (
SELECT id_maniobra, COUNT(id) AS numero_contenedores
FROM maniobra_contenedores
GROUP BY id_maniobra
) c ON c.id_maniobra = maniobra.id_maniobra
LEFT JOIN flota ON flota.vehicle_id = maniobra.vehicle_id
LEFT JOIN precios_maniobra ON precios_maniobra.numero_contenedores = c.numero_contenedores
AND precios_maniobra.peligroso = maniobra.peligroso
LEFT JOIN maniobra_contenedores ON maniobra_contenedores.id_maniobra = maniobra.id_maniobra
WHERE maniobra.operador_id = 1070
GROUP BY maniobra.id_maniobra";
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
