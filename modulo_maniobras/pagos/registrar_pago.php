<?php
require_once('getManiobrasOperador.php');

function registrarPago($operador_id, $periodo_inicio, $periodo_fin)
{
    require_once('../../postgresql/conexion.php');
    $cn = conectarPostgresql();
    $fecha_hora_actual = date('Y-m-d H:i:s');

    try {
        $cn->beginTransaction();

        $sql = "INSERT INTO pagos_maniobras (id_operador, fecha_pago, periodo_inicio, periodo_fin, monto_total)
            VALUES (:id_operador, :fecha_pago, :periodo_inicio, :periodo_fin, 0)";

        $stmt = $cn->prepare($sql);

        $stmt->bindParam(':id_operador', $operador_id);
        $stmt->bindParam(':fecha_pago', $fecha_hora_actual);
        $stmt->bindParam(':periodo_inicio', $periodo_inicio);
        $stmt->bindParam(':periodo_fin', $periodo_fin);

        $stmt->execute();
        $id_pago = $cn->lastInsertId();

        $resultados = obtenerManiobras($operador_id, $periodo_inicio, $periodo_fin);

        if (isset($resultados['error'])) {
            echo "Ocurrió un error: " . $resultados['error'];
            return;
        }

        if (empty($resultados)) {
            echo "No se encontraron maniobras para el operador en el rango de fechas especificado.";
            return;
        }

        foreach ($resultados as $registro) {
            $id_maniobra = $registro['id_maniobra'];
            $clave = $registro['clave'];
            $precio = $registro['precio'];

            $sql2 = "INSERT INTO detalle_pago_maniobra (id_pago, id_maniobra, clave, monto)
            VALUES (:id_pago, :id_maniobra, :clave, :monto)";

            $stmt = $cn->prepare($sql2);

            $stmt->bindParam(':id_pago', $id_pago);
            $stmt->bindParam(':id_maniobra', $id_maniobra);
            $stmt->bindParam(':clave', $clave);
            $stmt->bindParam(':monto', $precio);

            $stmt->execute();
        }

        $cn->commit();

        echo json_encode(["mensaje" => "Inserción exitosa"]);
    } catch (PDOException $e) {
        $cn->rollBack();
        echo json_encode(["error" => "Error en la inserción: " . $e->getMessage()]);
    }
}

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$operador_id = $data['operador_id'];
$periodo_inicio = $data['periodo_inicio'];
$periodo_fin = $data['periodo_fin'];

registrarPago($operador_id, $periodo_inicio, $periodo_fin);
