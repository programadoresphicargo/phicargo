<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

// Consulta para obtener los correos de MySQL
$SqlSelect = "SELECT * FROM correos_electronicos ORDER BY id_correo ASC";
$resultado = $cn->query($SqlSelect);

$correos = [];
$totalCorreos = 0; // Variable para contar los registros seleccionados

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row;  // Se almacena cada fila en el array
        $totalCorreos++; // Contar cada registro seleccionado
    }
}

// Conectar a la base de datos PostgreSQL
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

// Consulta preparada para insertar en PostgreSQL
$sqlInsert = "INSERT INTO correos_electronicos (
    id_correo, id_cliente, nombre_completo, correo, tipo, estado
) VALUES (:id_correo, :id_cliente, :nombre_completo, :correo, :tipo, :estado)";

// Preparar la consulta
$statement = $cn->prepare($sqlInsert);

$i = 0; // Contador de registros insertados

// Iterar sobre los correos y realizar la inserción
foreach ($correos as $correo) {
    try {
        // Ejecutar la inserción
        $result = $statement->execute([
            ':id_correo' => $correo['id_correo'],
            ':id_cliente' => $correo['id_cliente'],
            ':nombre_completo' => $correo['nombre_completo'],
            ':correo' => $correo['correo'],
            ':tipo' => $correo['tipo'],
            ':estado' => $correo['estado']
        ]);

        if ($result) {
            echo $i . " Insertado correctamente: ID: " . $correo['id_correo'] . ", Correo: " . $correo['correo'] . "<br>";
            $i++; // Incrementar el contador solo si la inserción fue exitosa
        } else {
            echo "Error al insertar el correo: " . $correo['correo'] . "<br>";
        }
    } catch (PDOException $e) {
        // Capturar y mostrar el error en caso de fallo
        echo "Error en la inserción del correo: " . $correo['correo'] . " - " . $e->getMessage() . "<br>";
    }
}

// Mostrar el total de registros insertados
echo "Total registros insertados: " . $i . "<br>";

// Verificar si la cantidad de registros insertados es igual a los seleccionados
if ($i === $totalCorreos) {
    echo "Todos los registros han sido insertados correctamente. Total registros: " . $totalCorreos;
} else {
    echo "No se insertaron todos los registros. Seleccionados: " . $totalCorreos . ", Insertados: " . $i;
}
?>
