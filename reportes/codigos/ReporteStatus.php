<?php
require_once("../../mysql/conexion.php");
$conn = conectar();

$operadores = $_POST['operadores'];
$rango = $_POST['rango'];
$array = explode(" ", $rango);
$inicio = $array[0];
$final =  $array[2];

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>

<table class="table table-sm" id="miTabla5">
    <thead>
        <tr>
            <th>Nombre Operador</th>
            <th>Contenedor</th>
            <th>Status</th>
            <th>Fecha Envío</th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($operadores as $op) {

            if ($op == 'todos') {
                $sql = "SELECT viajes.id, referencia, employee_id, nombre_operador, fecha_inicio, x_reference, status, fecha_envio 
                FROM viajes 
                INNER JOIN operadores ON operadores.id = viajes.employee_id 
                INNER JOIN correos ON correos.id_viaje = viajes.id 
                WHERE correos.id_ubicacion IS NULL 
                AND DATE(fecha_envio) BETWEEN '$inicio' AND '$final' 
                ORDER BY nombre_operador, referencia, fecha_envio ASC";
            } else {
                $sql = "SELECT viajes.id, referencia, employee_id, nombre_operador, fecha_inicio, x_reference, status, fecha_envio 
        FROM viajes 
        INNER JOIN operadores ON operadores.id = viajes.employee_id 
        INNER JOIN correos ON correos.id_viaje = viajes.id 
        WHERE correos.id_ubicacion IS NULL 
        AND employee_id = $op
        AND DATE(fecha_envio) BETWEEN '$inicio' AND '$final' 
        ORDER BY nombre_operador, referencia, fecha_envio ASC";
            }
            $result = $conn->query($sql);

            // Crea un array multidimensional para almacenar los datos agrupados y las sumas
            $treeview_data = array();
            $total_registros = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Agrupa los resultados por nombre_operador y referencia
                    $treeview_data[$row['nombre_operador']][$row['referencia']][] = $row;
                    // Incrementa el contador de registros
                    $total_registros++;
                }
            }

        ?>
        <?php
            // Recorre el array multidimensional para crear la tabla HTML con la estructura de treeview
            if ($result->num_rows > 0) {
                foreach ($treeview_data as $nombre_operador => $referencias) {
                    echo '<tr class="tree-node bg-primary text-white">';
                    echo '<td colspan="6">' . $nombre_operador . ' (Viajes: ' . count($referencias) . ')</td>';
                    echo '</tr>';

                    foreach ($referencias as $referencia => $viajes) {
                        echo '<tr class="tree-node bg-soft-primary text-dark">';
                        echo '<td class="tree-item" colspan="6">' . $referencia . ' (Estatus reportados: ' . count($viajes) . ')</td>';
                        echo '</tr>';

                        foreach ($viajes as $viaje) {
                            echo '<tr>';
                            echo '<td></td>'; // Celda vacía para indentación
                            echo '<td>' . $viaje['x_reference'] . '</td>';
                            echo '<td>' . $viaje['status'] . '</td>';
                            echo '<td>' . $viaje['fecha_envio'] . '</td>';
                            echo '</tr>';
                        }
                    }
                }
            }
            // Muestra la suma total de registros
        }
        echo '<tr>';
        echo '<td colspan="6"><strong>Total Registros:</strong> ' . $total_registros . '</td>';
        echo '</tr>';
        ?>
    </tbody>
</table>