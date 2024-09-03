<?php
require_once('../../mysql/conexion_inventario.php');

$cn = conectar();
$sqlSelect = "SELECT puesto, nombre_dep, nombre_empleado, apellido_paterno, apellido_materno,  NUMERO_CELULAR FROM activo INNER JOIN empleado ON ACTIVO.ID_EMPLEADO = EMPLEADO.ID_EMPLEADO INNER JOIN CELULAR ON activo.id_celular = celular.id_celular INNER JOIN DEPARTAMENTO ON DEPARTAMENTO.ID_DEPARTAMENTO = EMPLEADO.ID_DEPARTAMENTO ORDER BY fecha_asignacion DESC";
$resultSet = $cn->query($sqlSelect);

while($row = mysqli_fetch_array($resultSet)) $array[] = $row;
echo $json = json_encode($array);
