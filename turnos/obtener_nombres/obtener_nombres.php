<?php
require_once('../../mysql/conexion.php');
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$sucursal = $_POST['sucursal'];

$cn = conectar();
$sqlSelect = "SELECT id_turno, placas FROM turnos where cola = false and fecha_archivado IS NULL and sucursal = '$sucursal' and id_operador = 0";
$result = $cn->query($sqlSelect);
while ($row = $result->fetch_assoc()) {
    $id_turno = $row['id_turno'];
    $placas = $row['placas'];
    $kwargs = ['order' => 'date desc', 'fields' => ['name', 'vehicle_id', 'employee_id'], 'limit' => 1];
    $partners = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.travel',
        'search_read',
        array(
            array(
                array('vehicle_id', '=', $placas),
            )
        ),
        $kwargs
    );
    $json = json_encode($partners);
    $bytes = file_put_contents("nombres.json", $json);
    if (file_exists('nombres.json')) {
        $filename = 'nombres.json';
        $data = file_get_contents($filename);
        $users = json_decode($data);

        foreach ($users as $user) {
            $id_operador = $user->employee_id[0];
            $sqlUpdate = "UPDATE turnos SET id_operador = $id_operador WHERE id_turno = $id_turno";
            $cn->query($sqlUpdate);
        }
    } else {
    }
}
