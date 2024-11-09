<?php
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

$sql = "SELECT 
res_company.name AS empresa,
res_store.name AS sucursal,
tms_travel.name,
tms_travel.x_status_viaje,
fleet_vehicle.name AS vehiculo,
hr_employee.name AS operador,
tms_waybill.x_modo_bel AS tipo,
tms_waybill.x_tipo_bel AS tipo_armado,
STRING_AGG(tms_waybill.x_reference, ', ') AS contenedores
FROM 
tms_travel
INNER JOIN 
fleet_vehicle ON fleet_vehicle.id = tms_travel.vehicle_id
INNER JOIN 
hr_employee ON hr_employee.id = tms_travel.employee_id
INNER JOIN 
res_store ON res_store.id = tms_travel.store_id
INNER JOIN 
tms_waybill ON tms_waybill.travel_id = tms_travel.id
INNER JOIN 
res_company ON res_company.id = tms_travel.company_id
WHERE 
tms_travel.x_status_viaje IN ('ruta', 'planta', 'retorno', 'resguardo') 
GROUP BY 
res_store.name, tms_travel.name, tms_travel.x_status_viaje, fleet_vehicle.name, hr_employee.name, tms_waybill.x_modo_bel, tms_waybill.x_tipo_bel, res_company.name
ORDER BY 
tms_travel.x_status_viaje DESC";
$stmt = $cn->prepare($sql);
$stmt->execute();

$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($options);
