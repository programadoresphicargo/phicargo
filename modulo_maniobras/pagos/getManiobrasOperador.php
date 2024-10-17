<?php
require_once('../../postgresql/conexion.php');

function obtenerManiobras($operador_id, $fecha_inicio, $fecha_fin)
{
  $pdo = conectarPostgresql();

  $sql = "WITH maniobras_calculadas AS (
    SELECT 
      fleet_vehicle.name AS unidad, 
      maniobras.*, 
      maniobras_terminales.terminal, 
      tms_waybill.partner_id,
      -- Definimos tipo_armado y maniobra_peligrosa como columnas calculadas
      CASE 
        WHEN maniobras.trailer2_id IS NOT NULL THEN 'FULL' 
        ELSE 'SENCILLO' 
      END AS tipo_armado,
      -- Nueva lógica para determinar si la maniobra es peligrosa
      CASE 
        WHEN EXISTS (
          SELECT 1
          FROM maniobras_contenedores mc
          LEFT JOIN tms_waybill tw ON tw.id = mc.id_cp
          WHERE mc.id_maniobra = maniobras.id_maniobra
          AND (
            tw.dangerous_cargo = TRUE 
            AND NOT (
              (tw.x_modo_bel = 'exp' AND maniobras.tipo_maniobra = 'retiro') OR 
              (tw.x_modo_bel = 'imp' AND maniobras.tipo_maniobra = 'ingreso')
            )
          )
        ) THEN 'SI'
        ELSE 'NO'
      END AS maniobra_peligrosa,
      -- Concatenar todos los contenedores relacionados
      STRING_AGG(tms_waybill.x_reference, ', ') AS contenedores,
      -- Columna clave simplificada
      CASE 
        WHEN maniobras.trailer2_id IS NOT NULL AND 
             EXISTS (
               SELECT 1
               FROM maniobras_contenedores mc
               LEFT JOIN tms_waybill tw ON tw.id = mc.id_cp
               WHERE mc.id_maniobra = maniobras.id_maniobra
               AND (
                 tw.dangerous_cargo = TRUE 
                 AND NOT (
                   (tw.x_modo_bel = 'exp' AND maniobras.tipo_maniobra = 'retiro') OR 
                   (tw.x_modo_bel = 'imp' AND maniobras.tipo_maniobra = 'ingreso')
                 )
               )
             ) THEN 'FP'  -- Full + Peligroso
        WHEN maniobras.trailer2_id IS NOT NULL THEN 'F'  -- Full + No Peligroso
        WHEN EXISTS (
          SELECT 1
          FROM maniobras_contenedores mc
          LEFT JOIN tms_waybill tw ON tw.id = mc.id_cp
          WHERE mc.id_maniobra = maniobras.id_maniobra
          AND (
            tw.dangerous_cargo = TRUE 
            AND NOT (
              (tw.x_modo_bel = 'exp' AND maniobras.tipo_maniobra = 'retiro') OR 
              (tw.x_modo_bel = 'imp' AND maniobras.tipo_maniobra = 'ingreso')
            )
          )
        ) THEN 'SP'  -- Sencillo + Peligroso
        ELSE 'S'  -- Sencillo + No Peligroso
      END AS clave
    FROM maniobras
    LEFT JOIN maniobras_terminales ON maniobras_terminales.id_terminal = maniobras.id_terminal
    LEFT JOIN fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id
    LEFT JOIN maniobras_contenedores ON maniobras_contenedores.id_maniobra = maniobras.id_maniobra
    LEFT JOIN tms_waybill ON tms_waybill.id = maniobras_contenedores.id_cp
    WHERE maniobras.operador_id = :operador_id 
      AND DATE(maniobras.inicio_programado) BETWEEN :fecha_inicio AND :fecha_fin
    GROUP BY maniobras.id_maniobra, fleet_vehicle.name, maniobras_terminales.*, fleet_vehicle.*, maniobras_terminales.terminal, tms_waybill.partner_id
)
SELECT 
    mc.*, 
    pm.*, 
    -- Aplicar la multiplicación por 2 si la terminal contiene 'REGULADOR'
    CASE 
      WHEN mc.terminal LIKE '%REGULADOR%' THEN pm.precio * 2
      ELSE pm.precio
    END AS precio_final
FROM maniobras_calculadas mc
LEFT JOIN precios_maniobra pm ON mc.clave = pm.clave
ORDER BY mc.inicio_programado ASC";

  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':operador_id' => $operador_id,
      ':fecha_inicio' => $fecha_inicio,
      ':fecha_fin' => $fecha_fin
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data; // Retornar los datos obtenidos
  } catch (PDOException $e) {
    return ['error' => 'Error en la consulta: ' . $e->getMessage()];
  }
}
