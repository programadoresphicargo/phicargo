<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$SqlSelect = "SELECT * FROM correos_electronicos ORDER BY correo ASC";
$resultado = $cn->query($SqlSelect);

$correos = [];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row;
    }
}

$jsonCorreos = json_encode($correos);

require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

$sqlInsert = "INSERT INTO correos_electronicos (
    id_correo, id_cliente, nombre_completo, correo, tipo, estado
) VALUES (:id_correo, :id_cliente, :nombre_completo, :correo, :tipo, :estado)";

$statement = $cn->prepare($sqlInsert);

foreach ($correos as $correo) {
    $result = $statement->execute([
        ':id_correo' => $correo['id_correo'],
        ':id_cliente' => $correo['id_cliente'],
        ':nombre_completo' => $correo['nombre_completo'],
        ':correo' => $correo['correo'],
        ':tipo' => $correo['tipo'],
        ':estado' => $correo['estado']
    ]);

    if ($result) {
        echo "Insertado correctamente: ID: " . $correo['id_correo'] . ", Correo: " . $correo['correo'] . "<br>";
    } else {
        echo "Error al insertar el correo: " . $correo['correo'] . "<br>";
    }
}
