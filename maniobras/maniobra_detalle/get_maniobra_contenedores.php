<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$sql = "SELECT * FROM maniobra_contenedores where id_maniobra = $id_maniobra";
$resultado = $cn->query($sql);

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

$data = [];

while ($row = $resultado->fetch_assoc()) {
    $contenedor_data = contenedor($row['id_cp']);
    foreach ($contenedor_data as $item) {
        $data[] = [
            'id' => $row['id'],
            'id_cp' => $item['id'],
            'x_reference' => $item['x_reference'],
            'x_reference_2' => $item['x_reference_2']
        ];
    }
}

echo json_encode($data); // Imprime el JSON al final
