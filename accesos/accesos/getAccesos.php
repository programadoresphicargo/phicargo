<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT * FROM acceso_peatonal 
left join empresas_accesos on empresas_accesos.id_empresa = acceso_peatonal.id_empresa
left join usuarios on usuarios.id_usuario = acceso_peatonal.usuario_creacion";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
