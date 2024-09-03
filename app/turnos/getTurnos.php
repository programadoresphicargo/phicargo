<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sucursal = $_POST['sucursal'];
if ($sucursal == 'cola_veracruz') {
    $SQL = "SELECT * FROM cola left join turnos on turnos.id_turno = cola.id_turno left join operadores on operadores.id = turnos.id_operador left join unidades on unidades.placas = turnos.placas where sucursal = 'veracruz' and cola_estado='espera'";
} else if ($sucursal == 'cola_manzanillo') {
    $SQL = "SELECT * FROM cola left join turnos on turnos.id_turno = cola.id_turno left join operadores on operadores.id = turnos.id_operador left join unidades on unidades.placas = turnos.placas where sucursal = 'manzanillo' and cola_estado='espera'";
} else if ($sucursal == 'turnos_veracruz') {
    $SQL = "SELECT id_turno, turno, id_operador, nombre_operador, unidades.placas, unidad, fecha_llegada, hora_llegada, comentarios, usuario_registro, fecha_registro, fijado, maniobra1, maniobra2 FROM turnos LEFT JOIN operadores ON turnos.id_operador = operadores.id LEFT JOIN unidades ON turnos.placas = unidades.placas where cola = false and fecha_archivado IS NULL and sucursal = 'veracruz' ORDER BY turno ASC";
} else if ($sucursal == 'turnos_manzanillo') {
    $SQL = "SELECT id_turno, turno, id_operador, nombre_operador, unidades.placas, unidad, fecha_llegada, hora_llegada, comentarios, usuario_registro, fecha_registro, fijado, maniobra1, maniobra2 FROM turnos LEFT JOIN operadores ON turnos.id_operador = operadores.id LEFT JOIN unidades ON turnos.placas = unidades.placas where cola = false and fecha_archivado IS NULL and sucursal = 'manzanillo' ORDER BY turno ASC";
} else if ($sucursal == 'turnos_mexico') {
    $SQL = "SELECT id_turno, turno, id_operador, nombre_operador, unidades.placas, unidad, fecha_llegada, hora_llegada, comentarios, usuario_registro, fecha_registro, fijado, maniobra1, maniobra2 FROM turnos LEFT JOIN operadores ON turnos.id_operador = operadores.id LEFT JOIN unidades ON turnos.placas = unidades.placas where cola = false and fecha_archivado IS NULL and sucursal = 'mexico' ORDER BY turno ASC";
}

$resultado = $cn->query($SQL);

if ($resultado) {
    $resultados_array = array();
    while ($fila = $resultado->fetch_assoc()) {
        $resultados_array[] = $fila;
    }

    $json_resultados = json_encode($resultados_array);

    echo $json_resultados;
} else {
    echo "Error en la consulta: " . $cn->error;
}

$cn->close();
