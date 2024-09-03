<?php
require_once('../../mysql/conexion.php');
require_once('../codigos/cambiar_estado.php');

function cargarPlantilla($file, $variables = [])
{
    if (!file_exists($file)) {
        return '';
    }
    $template = file_get_contents($file);
    foreach ($variables as $key => $value) {
        $template = str_replace('{{' . $key . '}}', $value, $template);
    }
    return $template;
}

function obtenerDestinatarios($cn, $id_viaje)
{
    $sql = "SELECT * FROM correos_viajes 
            INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_viajes.ID_CORREO 
            WHERE ID_VIAJE = $id_viaje AND TIPO = 'Destinatario'";
    return $cn->query($sql)->fetch_all(MYSQLI_ASSOC);
}

function obtenerCC($cn, $id_viaje)
{
    $sql = "SELECT * FROM correos_viajes 
            INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_viajes.ID_CORREO 
            WHERE ID_VIAJE = $id_viaje AND TIPO = 'CC'";
    return $cn->query($sql)->fetch_all(MYSQLI_ASSOC);
}

function devolver_status($id_viaje, $estado, $modo, $velocidad)
{
    require_once('../../mysql/conexion.php');
    $cn = conectar();

    if ($cn->connect_error) {
        die("Conexión fallida: " . $cn->connect_error);
    }

    $id_status = 0;

    switch ($estado) {
        case 'ruta':
            $id_status = ($velocidad > 1) ? 101 : 102;
            break;

        case 'planta':
            $sql = $cn->prepare("SELECT * FROM reportes_estatus_viajes WHERE id_viaje = ? ORDER BY fecha_envio DESC LIMIT 1");
            $sql->bind_param("i", $id_viaje);
            $sql->execute();
            $resultado = $sql->get_result();

            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                switch ($row['id_estatus']) {
                    case 3:
                    case 300:
                        $id_status = 300;
                        break;
                    case 4:
                    case 301:
                        $id_status = 301;
                        break;
                    case 5:
                    case 302;
                    case 303;
                        if ($modo == 'imp') {
                            $id_status = 303;
                        } else if ($modo == 'exp') {
                            $id_status = 302;
                        }
                        break;
                    case 6:
                    case 304;
                    case 305;
                        if ($modo == 'imp') {
                            $id_status = 305;
                        } else if ($modo == 'exp') {
                            $id_status = 304;
                        }
                        break;
                    case 7:
                    case 306:
                        $id_status = 306;
                        break;
                    default:
                        $id_status = 100;
                        break;
                }
            } else {
            }

            $sql->close();
            break;

        case 'retorno':
            if ($modo == 'exp') {
                $id_status = ($velocidad >= 0) ? 98 : 99;
            } elseif ($modo == 'imp') {
                $id_status = ($velocidad >= 0) ? 96 : 97;
            }
            break;

        default:
            // Manejo de caso por defecto si es necesario
            break;
    }

    $cn->close();
    return $id_status;
}

function guardar_status($id, $id_ubicacion, $hora, $status, $latitud, $longitud, $ciudad_referencia, $calle)
{
    $cn = conectar();
    $sqlInsert = "INSERT INTO correos VALUES(NULL, $id, $id_ubicacion, null, null, '$hora','$status',0)";
    if ($cn->query($sqlInsert)) {
        $sqlUpdateUltimoEnvio = "UPDATE viajes set ultimo_envio = '$hora' where id = $id";
        if ($cn->query($sqlUpdateUltimoEnvio)) {
            include('../../odoo/odoo-conexion.php');
            if (!empty($uid)) {
                $values = [
                    'travel_id' => $id,
                    'status' => $status,
                    'location' => 'Lat: ' . $latitud . ', Long: ' . $longitud . ', ' . $ciudad_referencia . ', ' . $calle,
                ];
                $partners = $models->execute_kw(
                    $db,
                    $uid,
                    $password,
                    'tms.travel.history.events',
                    'create',
                    [$values]
                );
                echo 1;
            } else {
                echo 2;
            }
        }
    } else {
        echo 3;
    }
}

function guardar_status_manual($id_viaje, $placas, $id_status, $status_nombre, $id_usuario, $latitud, $longitud, $localidad, $sublocalidad, $calle, $codigo_postal, $velocidad, $fecha_hora, $comentarios, $fecha_actual, $files)
{
    $cn = conectar();
    $cn->begin_transaction();

    try {
        $sqlInsert = "INSERT INTO ubicaciones_estatus VALUES(NULL, '$placas', $latitud, $longitud,'$localidad','$sublocalidad','$calle',$codigo_postal,'$fecha_hora')";
        if (!$cn->query($sqlInsert)) {
            throw new Exception("Error al insertar en ubicaciones_estatus: " . $cn->error);
        }

        $id_ubicacion = $cn->insert_id;
        $sqlInsert = "INSERT INTO reportes_estatus_viajes VALUES(NULL, $id_viaje, $id_status, $id_ubicacion, $id_usuario, '$fecha_actual', '$comentarios')";
        if (!$cn->query($sqlInsert)) {
            throw new Exception("Error al insertar en reportes_estatus_viajes: " . $cn->error);
        } else {
            $id_reporte = $cn->insert_id;
            $target_dir = "../../gestion_viajes/adjuntos_estatus/$id_viaje/";
            if (!file_exists($target_dir)) {
                if (mkdir($target_dir, 0777, true)) {
                } else {
                }
            }

            if (!empty($files['tmp_name'])) {
                foreach ($files['tmp_name'] as $key => $tmpName) {
                    $nombre = $files['name'][$key];
                    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
                    $target_file = $target_dir . basename($files["name"][$key]);
                    if (move_uploaded_file($files["tmp_name"][$key], $target_file)) {
                        $sqlAdjunto = "INSERT INTO archivos_adjuntos VALUES (NULL, $id_reporte, '$nombre', '$extension', $id_usuario, '$fecha_actual')";
                        if (!$cn->query($sqlAdjunto)) {
                            throw new Exception("Error al insertar en reportes_estatus_viajes: " . $cn->error);
                        }
                    }
                }
            }
        }

        if ($id_usuario == 8) {
            $sqlUpdateUltimoEnvio = "UPDATE viajes SET ultimo_envio = '$fecha_actual' WHERE id = $id_viaje";
            if (!$cn->query($sqlUpdateUltimoEnvio)) {
                throw new Exception("Error al actualizar ultimo_envio en viajes: " . $cn->error);
            }
        }

        if ($id_status == 1) {
            $sqlActivar = "UPDATE viajes set fecha_inicio = '$fecha_actual', ultimo_envio = '$fecha_actual', usuario_inicio = $id_usuario where id = $id_viaje";
            if (!$cn->query($sqlActivar)) {
                throw new Exception("Error al actualizar ultimo_envio en viajes: " . $cn->error);
            }
        }

        if ($id_status == 103) {
            $sqlFinalizar = "UPDATE viajes SET estado = 'Finalizado', usuario_finalizado = $id_usuario, ultimo_envio = '$fecha_actual', fecha_finalizado = '$fecha_actual'  WHERE id = '$id_viaje'";
            if (!$cn->query($sqlFinalizar)) {
                throw new Exception("Error al actualizar ultimo_envio en viajes: " . $cn->error);
            }
        }

        include('../../odoo/odoo-conexion.php');
        if (!empty($uid)) {
            $values = [
                'travel_id' => $id_viaje,
                'status' => $status_nombre,
                'location' => 'Lat: ' . $latitud . ', Long: ' . $longitud . ', ' . $calle . ', ' . $calle,
            ];
            $partners = $models->execute_kw(
                $db,
                $uid,
                $password,
                'tms.travel.history.events',
                'create',
                [$values]
            );

            if ($id_status == 17) {
                recordar_ultimo($id_viaje);
            }

            $cn->commit();
            echo 1;
        } else {
            throw new Exception("Error: uid vacío");
        }
    } catch (Exception $e) {
        $cn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

function recordar_ultimo($id_viaje)
{
    $cn = conectar();
    $sqlSelect = "SELECT * FROM reportes_estatus_viajes where id_viaje = $id_viaje and id_estatus in (8)";
    $resultado = $cn->query($sqlSelect);
    if ($resultado->num_rows > 0) {
        cambiar_estado($id_viaje, 8);
    } else {
        $sqlSelect = "SELECT * FROM reportes_estatus_viajes where id_viaje = $id_viaje and id_estatus in (3,4,5)";
        $resultado = $cn->query($sqlSelect);
        if ($resultado->num_rows > 0) {
            cambiar_estado($id_viaje, 3);
        } else {
            cambiar_estado($id_viaje, 1);
        }
    }
}

function guardar_status_operador($id, $ubicacion, $comentarios, $hora, $status, $id_operador, $imagen)
{
    $cn = conectar();
    $sqlInsert = "INSERT INTO correos VALUES(NULL, $id, NULL ,'$ubicacion','$comentarios', '$hora','$status', $id_operador)";
    if ($cn->query($sqlInsert)) {
        include('../../odoo/odoo-conexion.php');
        if (!empty($uid)) {
            $values = [
                'travel_id' => $id,
                'status' => $status,
                'location' => $ubicacion,
                'name' => $comentarios,
                'x_envio' => 'Operador',
                'x_foto' => $imagen
            ];
            $partners = $models->execute_kw(
                $db,
                $uid,
                $password,
                'tms.travel.history.events',
                'create',
                [$values]
            );
            echo 1;
        } else {
            echo 5;
        }
    } else {
        echo 3;
    }
}

function guardar_status_maniobra($id_cp, $id_operador, $id_status, $latitud, $longitud, $calle, $localidad, $sublocalidad, $codigo_postal, $fecha_hora, $tipo, $comentarios, $id_evidencia)
{
    $cn = conectar();

    $cn->autocommit(false);
    try {
        $sqlInsert = "INSERT INTO ubicaciones_maniobras VALUES(NULL,$id_operador,'$latitud','$longitud','$calle','$localidad','$sublocalidad','$codigo_postal','$fecha_hora')";
        $cn->query($sqlInsert);

        $SqlSelect = "SELECT id_ubicacion FROM ubicaciones_maniobras where id_operador = $id_operador order by fecha desc";
        $resultado = $cn->query($SqlSelect);
        $row = $resultado->fetch_assoc();
        $id_ubicacion = $row['id_ubicacion'];
        $cn->query($SqlSelect);

        $sqlInsertStatusManiobra = "INSERT INTO status_maniobras VALUES(NULL, $id_cp, '$tipo' , null,$id_ubicacion,$id_status,0,'$fecha_hora','$comentarios',$id_evidencia)";
        $cn->query($sqlInsertStatusManiobra);

        $cn->commit();
        echo 1;
    } catch (Exception $e) {
        $cn->rollback();
        echo $e;
    }
}

function guardar_resguardo($id_viaje, $id_ubicacion, $hora)
{
    $cn = conectar();
    $sqlInsert = "INSERT INTO resguardos VALUES(NULL,$id_viaje,$id_ubicacion,'$hora',NULL)";
    $cn->query($sqlInsert);
    cambiar_estado($id_viaje, 'Resguardo');
}

function guardar_resguardo_final($id_viaje, $hora)
{
    $cn = conectar();
    $sqlInsert = "UPDATE resguardos set fecha_hora_fin = '$hora' where id_viaje = $id_viaje and fecha_hora_fin = NULL";
    $cn->query($sqlInsert);
}
