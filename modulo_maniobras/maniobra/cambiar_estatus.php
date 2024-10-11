<?php

function actualizar_estado_contenedor($id_maniobra, $estatus)
{
    require_once('../../postgresql/conexion.php');
    require_once('../../odoo/odoo-conexion.php');

    $cn = conectarPostgresql();
    $sql = "SELECT * FROM maniobras 
    inner join maniobras_contenedores on maniobras_contenedores.id_maniobra = maniobras.id_maniobra 
    where maniobras.id_maniobra = :id_maniobra";
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id_maniobra' => $id_maniobra]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $partner_record_ids = [intval($row['id_cp'])];
        $partner_value = [
            'x_status_bel' => $estatus,
        ];
        $values = [$partner_record_ids, $partner_value];
        $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
    }
}
