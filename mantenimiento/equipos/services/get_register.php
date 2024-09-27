<?php

function getRecordById(PDO $cn, int $id) {
  $query = "SELECT 
              mr.id, 
              mr.workshop_id,
              mw.name AS workshop_name,
              mr.fail_type, 
              mr.check_in, 
              mr.check_out, 
              mr.status, 
              mr.delivery_date, 
              mr.supervisor,
              mr.comments,
              mr.order_service,
              fv.id AS tract_id, 
              fv.name2 AS tract_name, 
              fv.x_tipo_vehiculo AS tract_x_tipo_vehiculo, 
              rs.id AS store_id, 
              rs.code AS store_code, 
              rs.name AS store_name,
              MAX(mc.created_at) AS last_comment_date
            FROM public.maintenance_record mr
            LEFT JOIN public.fleet_vehicle fv ON mr.tract_id = fv.id 
            LEFT JOIN public.res_store rs ON fv.x_sucursal = rs.id
            LEFT JOIN public.maintenance_workshops mw ON mr.workshop_id = mw.id
            LEFT JOIN public.maintenance_comments mc ON mr.id = mc.maintenance_record_id
            WHERE mr.id = ?
            GROUP BY 
              mr.id, 
              mr.workshop_id,
              mw.name,
              mr.fail_type, 
              mr.check_in, 
              mr.check_out, 
              mr.status, 
              mr.delivery_date, 
              mr.supervisor,
              mr.comments,
              mr.order_service,
              fv.id, 
              fv.name2, 
              fv.x_tipo_vehiculo, 
              rs.id, 
              rs.code, 
              rs.name
            ORDER BY mr.id";

  $stmt = $cn->prepare($query);
  $stmt->execute([$id]);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($record) {
    return [
      "id" => $record['id'],
      "workshop" => [
        "id" => $record['workshop_id'],
        "name" => $record['workshop_name']
      ],
      "fail_type" => $record['fail_type'],
      "check_in" => $record['check_in'],
      "check_out" => $record['check_out'],
      "status" => $record['status'],
      "delivery_date" => $record['delivery_date'],
      "supervisor" => $record['supervisor'],
      "comments" => $record['comments'],
      "order_service" => $record['order_service'],
      "last_comment_date" => $record['last_comment_date'],
      "tract" => [
        "id" => $record['tract_id'],
        "name2" => $record['tract_name'],
        "x_tipo_vehiculo" => $record['tract_x_tipo_vehiculo'],
        "x_sucursal" => [
          "id" => $record['store_id'],
          "code" => $record['store_code'],
          "name" => $record['store_name']
        ]
      ]
    ];
  }

  return null;
}