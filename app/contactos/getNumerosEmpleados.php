<?php
require_once('../../mysql/conexion_inventario.php');

$cn = conectar_inventario();
$id_departamento = $_POST['id_departamento'];
$sqlSelect = "SELECT puesto, nombre_dep, nombre_empleado, apellido_paterno, apellido_materno, foto, NUMERO_CELULAR FROM activo INNER JOIN empleado ON activo.ID_EMPLEADO = empleado.ID_EMPLEADO INNER JOIN celular ON activo.id_celular = celular.id_celular INNER JOIN departamento ON departamento.ID_DEPARTAMENTO = empleado.ID_DEPARTAMENTO where departamento.id_departamento = $id_departamento ORDER BY fecha_asignacion DESC;";
$resultSet = $cn->query($sqlSelect);

while($row = mysqli_fetch_array($resultSet)) $array[] = $row;
echo $json = json_encode($array);
