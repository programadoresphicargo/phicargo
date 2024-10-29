<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$estado_acceso = $_GET['estado_acceso'];

if ($estado_acceso == 'peatonal') {
    $sql = "SELECT 
    accesos.id_acceso,
    empresas_accesos.nombre_empresa,
    accesos.tipo_movimiento,
    accesos.fecha_entrada,
    usuarios.nombre,
    accesos.estado_acceso,
    empresas.nombre as empresa_visitada
   FROM accesos 
   inner join empresas_accesos on empresas_accesos.id_empresa = accesos.id_empresa
   inner join usuarios on usuarios.id_usuario = accesos.usuario_creacion
   inner join acceso_visitante ON accesos.id_acceso = acceso_visitante.id_acceso
   inner join empresas on empresas.id_empresa = accesos.id_empresa_visitada
   where accesos.estado_acceso != 'archivado'
   AND 
    accesos.id_acceso NOT IN (
        SELECT id_acceso FROM acceso_vehicular
    )
    group by accesos.id_acceso
   order by fecha_creacion desc";
} else if ($estado_acceso == 'vehicular') {
    $sql = "SELECT 
    accesos.id_acceso,
    empresas_accesos.nombre_empresa,
    accesos.tipo_movimiento,
    accesos.fecha_entrada,
    usuarios.nombre,
    accesos.estado_acceso,
    empresas.nombre as empresa_visitada
    FROM accesos 
    inner join empresas_accesos on empresas_accesos.id_empresa = accesos.id_empresa
    inner join usuarios on usuarios.id_usuario = accesos.usuario_creacion
    inner join acceso_vehicular ON accesos.id_acceso = acceso_vehicular.id_acceso
    inner join empresas on empresas.id_empresa = accesos.id_empresa_visitada
    where accesos.estado_acceso != 'archivado'
    group by accesos.id_acceso
    order by fecha_creacion desc";
} else if ($estado_acceso == 'archivado') {
    $sql = "SELECT 
    accesos.id_acceso,
    empresas_accesos.nombre_empresa,
    accesos.tipo_movimiento,
    accesos.fecha_entrada,
    usuarios.nombre,
    accesos.estado_acceso,
    empresas.nombre as empresa_visitada
    FROM accesos 
    left join empresas_accesos on empresas_accesos.id_empresa = accesos.id_empresa
    left join usuarios on usuarios.id_usuario = accesos.usuario_creacion
    left join empresas on empresas.id_empresa = accesos.id_empresa_visitada
    where accesos.estado_acceso = 'archivado'
    order by fecha_creacion desc";
}

$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
