<?php

require_once('../../postgresql/conexion.php');
$pdo = conectarPostgresql();

if ($pdo) {
    try {
        $sql = "SELECT 
        fleet_vehicle.id as id_vehicle, res_store.name as sucursal, 
        fleet_vehicle.x_modalidad as x_mod,
        hr_employee.name as operador_asignado,
        fleet_vehicle_state.name as estado_unidad,
        * FROM fleet_vehicle 
        left join res_store on res_store.id = fleet_vehicle.x_sucursal
        left join hr_employee on hr_employee.id = fleet_vehicle.x_operador_asignado
        left join fleet_vehicle_state on fleet_vehicle_state.id = fleet_vehicle.state_id
        where vehicle_type_id = :vehicle_type_id and supplier_vehicle != true and fleet_vehicle.active = true
        order by fleet_vehicle.name asc";
        $stmt = $pdo->prepare($sql);
        $valor = 2162;
        $stmt->bindParam(':vehicle_type_id', $valor);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultados);
    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
}

$domain[0][] = ['vehicle_type_id', '=', 2162];
$domain[0][] = ['supplier_vehicle', '!=', true];
