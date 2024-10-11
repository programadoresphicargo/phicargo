<?php
require_once('../../mysql/conexion.php');
require_once('../../postgresql/conexion.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviar_correo($id_maniobra, $id_reporte, $files, $id_usuario)
{
    date_default_timezone_set('America/Mexico_City');
    $hora = date('Y-m-d H:i:s');

    $cn = conectarPostgresql();

    include_once '../../vendor/autoload.php';
    include_once '../../PHPMailer/src/PHPMailer.php';
    include_once '../../PHPMailer/src/SMTP.php';
    include_once '../../PHPMailer/src/Exception.php';

    try {
        $Datos = file_get_contents('../../ajustes/configuraciones/GuardarDatosCorreos.json');
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $decoded_json = json_decode($Datos, true);

    $HOST = $decoded_json[0];
    $PORT = $decoded_json[1];
    $MAIL = $decoded_json[2];
    $PASSWOORD = $decoded_json[3];
    $USERREALNAME = $decoded_json[4];

    $SqlSelectDestinatario = "SELECT correo FROM maniobras_correos 
    INNER JOIN correos_electronicos 
    ON correos_electronicos.id_correo = maniobras_correos.id_correo 
    WHERE id_maniobra = :id_maniobra AND tipo = 'Destinatario'";
    $stmtDestinatario = $cn->prepare($SqlSelectDestinatario);
    $stmtDestinatario->execute([':id_maniobra' => $id_maniobra]);

    $SqlSelectCC = "SELECT correo FROM maniobras_correos 
    INNER JOIN correos_electronicos 
    ON correos_electronicos.id_correo = maniobras_correos.id_correo 
    WHERE id_maniobra = :id_maniobra AND tipo = 'CC'";
    $stmtCC = $cn->prepare($SqlSelectCC);
    $stmtCC->execute([':id_maniobra' => $id_maniobra]);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $HOST;
        $mail->SMTPAuth = true;
        $mail->Username = $MAIL;
        $mail->Password = $PASSWOORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $PORT;

        $mail->setFrom($MAIL, $USERREALNAME);
        $mail->addReplyTo($MAIL, $USERREALNAME);

        //        while ($rowDestinatario = $stmtDestinatario->fetch(PDO::FETCH_ASSOC)) {
        //           $mail->addAddress($rowDestinatario['correo']);
        //            echo 'Destinatario: ' . $rowDestinatario['correo'] . '<br>';
        //      }

        //    while ($rowCC = $stmtCC->fetch(PDO::FETCH_ASSOC)) {
        //      $mail->addCC($rowCC['correo']);
        //     echo 'CC: ' . $rowCC['correo'] . '<br>';
        // }

        $mail->addAddress('desarrollador@phi-cargo.com', '');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $SqlManiobra = "SELECT 
        reportes_estatus_maniobras.*, 
        status.status, 
        ubicaciones_maniobras.*, 
        maniobras.*, 
        fleet_vehicle.name, 
        STRING_AGG(tms_waybill.x_reference, ', ') AS contenedores,
        tms_waybill.x_reference,
        tms_waybill.client_order_ref
    FROM 
        reportes_estatus_maniobras 
    LEFT JOIN 
        status ON status.id_status = reportes_estatus_maniobras.id_estatus
    LEFT JOIN 
        ubicaciones_maniobras ON ubicaciones_maniobras.id_ubicacion = reportes_estatus_maniobras.id_ubicacion
    LEFT JOIN 
        maniobras ON maniobras.id_maniobra = reportes_estatus_maniobras.id_maniobra
    LEFT JOIN 
        fleet_vehicle ON fleet_vehicle.id = maniobras.vehicle_id
    LEFT JOIN 
        maniobras_contenedores ON maniobras_contenedores.id_maniobra = maniobras.id_maniobra
    LEFT JOIN 
        tms_waybill ON tms_waybill.id = maniobras_contenedores.id_cp
    WHERE 
        reportes_estatus_maniobras.id_reporte = $id_reporte 
    GROUP BY 
        reportes_estatus_maniobras.id_reporte, 
        status.id_status, 
        ubicaciones_maniobras.id_ubicacion, 
        maniobras.id_maniobra, 
        fleet_vehicle.id, 
        tms_waybill.id,
        ubicaciones_maniobras.id_ubicacion
    ORDER BY 
        reportes_estatus_maniobras.fecha_hora DESC";

        $stmt = $cn->query($SqlManiobra);
        $resultManiobra = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Subject = '';
        foreach ($resultManiobra as $rowManiobra) {
            $template = file_get_contents('../plantilla/plantilla.php');

            $Subject = $rowManiobra['client_order_ref'] . ' / Actualización de estatus en maniobra de ' . $rowManiobra['tipo_maniobra'] . ' / ' . $rowManiobra['contenedores'];
            $template = str_replace('{{status}}', htmlspecialchars($rowManiobra['status']), $template);
            $template = str_replace('{{tipo_maniobra}}', htmlspecialchars($rowManiobra['tipo_maniobra']), $template);
            $template = str_replace('{{referencia_cliente}}', htmlspecialchars($rowManiobra['client_order_ref']), $template);
            $template = str_replace('{{contenedores}}', htmlspecialchars($rowManiobra['contenedores']), $template);
            $template = str_replace('{{comentarios_estatus}}', htmlspecialchars($rowManiobra['comentarios_estatus']), $template);
            $template = str_replace('{{latitud}}', htmlspecialchars($rowManiobra['latitud']), $template);
            $template = str_replace('{{longitud}}', htmlspecialchars($rowManiobra['longitud']), $template);
            $template = str_replace('{{referencia}}', htmlspecialchars($rowManiobra['calle']), $template);
            $template = str_replace('{{calle}}', htmlspecialchars($rowManiobra['sublocalidad']), $template);
            $template = str_replace('{{fecha}}', htmlspecialchars($rowManiobra['fecha_hora']), $template);
            $template = str_replace('{{unidad}}', htmlspecialchars($rowManiobra['name']), $template);
        }
        $mail->addCustomHeader('In-Reply-To', $Subject);
        $mail->addCustomHeader('References', $Subject);
        $mail->Subject = $Subject;
        $mail->Body = $template;

        if (!empty($files)) {
            $fileCount = count($files['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $files['name'][$i];
                $fileTmpName = $files['tmp_name'][$i];
                $fileError = $files['error'][$i];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                if ($fileError === UPLOAD_ERR_OK) {
                    $uploadDir = '../../maniobras_evidencias/M_' . $id_maniobra . '/';
                    $destination = $uploadDir . basename($fileName);

                    if (!is_dir($uploadDir)) {
                        if (!mkdir($uploadDir, 0777, true)) {
                            continue;
                        }
                    }

                    if (move_uploaded_file($fileTmpName, $destination)) {
                        $insert = "INSERT INTO archivos_adjuntos_maniobras (id_reporte, nombre, extension, id_usuario, fecha_envio) 
                        VALUES (?, ?, ?, ?, ?)";
                        $stmt4 = $cn->prepare($insert);
                        $stmt4->execute([$id_reporte, $fileName, $fileExtension, $id_usuario, $hora]);
                        $mail->addAttachment($destination, $fileName);
                    } else {
                        //echo 'Error al mover el archivo: ' . $fileName;
                    }
                } else {
                    //echo 'Error subiendo el archivo: ' . $fileName;
                }
            }
        }

        if ($mail->send()) {
            echo json_encode([
                'success' => true,
                'message' => 'El correo se envió correctamente.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al enviar el correo: ' . $mail->ErrorInfo
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al enviar el correo: ' . $e->getMessage()
        ]);
    }
}

function obtenerPlacas($id_maniobra)
{
    $cn2 = conectarPostgresql();

    $SqlSelect = "SELECT vehicle_id FROM maniobras WHERE id_maniobra = :id_maniobra";
    $stmt = $cn2->prepare($SqlSelect);
    $stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$resultado) {
        return "No se encontró la maniobra.";
    }

    $vehicle_id = $resultado['vehicle_id'];
    $sqlVehicle = "SELECT license_plate FROM fleet_vehicle WHERE id = :vehicle_id";
    $stmt2 = $cn2->prepare($sqlVehicle);
    $stmt2->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if (!$row2) {
        return "No se encontró el vehículo.";
    }

    $placas = $row2['license_plate'];
    return $placas;
}


function guardar_base_datos($id_maniobra, $automatico, $id_estatus, $id_usuario, $comentario, $files)
{
    date_default_timezone_set('America/Mexico_City');
    $hora = date('Y-m-d H:i:s');
    $cn = conectar();
    $cn2 = conectarPostgresql();

    $placas = obtenerPlacas($id_maniobra);

    $SQL = "SELECT * FROM ubicaciones WHERE placas = ? ORDER BY fecha_hora DESC LIMIT 1";
    $stmt = $cn->prepare($SQL);
    $stmt->bind_param('s', $placas);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "No se encontró la ubicación para las placas proporcionadas.";
        return;
    }

    $latitud = $row['latitud'];
    $longitud = $row['longitud'];
    $referencia = $row['referencia'];
    $calle = $row['calle'];
    $fecha_hora = $row['fecha_hora'];
    $velocidad = $row['velocidad'];

    if ($automatico) {
        $id_estatus = ($velocidad >= 1) ? 80 : 81;
        if (preg_match('/\((.*?)\)/', $referencia, $matches)) {
            $comentario = $matches[1];
        } else {
            echo "No se encontró comentario en los paréntesis <br>";
            return;
        }

        $validacionSQL = "SELECT comentarios_estatus, fecha_hora FROM reportes_estatus_maniobras 
                      WHERE id_maniobra = ? ORDER BY fecha_hora DESC LIMIT 1";
        $stmt2 = $cn2->prepare($validacionSQL);
        $stmt2->execute([$id_maniobra]);
        $ultimoRegistro = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($ultimoRegistro) {
            $ultimoComentario = $ultimoRegistro['comentarios_estatus'];
            $ultimaFechaHora = $ultimoRegistro['fecha_hora'];

            $diferenciaTiempo = (strtotime($hora) - strtotime($ultimaFechaHora)) / 60;

            if ($ultimoComentario === $comentario && $diferenciaTiempo < 30) {
                echo "No se insertó el registro: El comentario es igual al último y no ha pasado media hora <br>";
                return;
            }

            if (strpos($comentario, 'BELCHEZ') !== false) {
                echo "No se insertó el registro: El comentario contiene la palabra 'BELCHEZ <br>";
                return;
            }
        }
    }

    $insert = "INSERT INTO ubicaciones_maniobras (placas, latitud, longitud, localidad, sublocalidad, calle, codigo_postal, fecha_hora) 
               VALUES (?, ?, ?, ?, ?, ?, 0, ?)";
    $stmt3 = $cn2->prepare($insert);
    if ($stmt3->execute([$placas, $latitud, $longitud, $referencia, $referencia, $calle, $fecha_hora])) {
        $id_ubicacion = $cn2->lastInsertId();

        $insert = "INSERT INTO reportes_estatus_maniobras (id_maniobra, id_ubicacion, id_estatus, id_usuario, fecha_hora, comentarios_estatus) 
                   VALUES (?, ?, ?, ?, ?, ?)";
        $stmt4 = $cn2->prepare($insert);
        if ($stmt4->execute([$id_maniobra, $id_ubicacion, $id_estatus, $id_usuario, $hora, $comentario])) {
            $id_reporte = $cn2->lastInsertId();

            enviar_correo($id_maniobra, $id_reporte, $files, $id_usuario);
        } else {
            echo "Error al insertar en reportes_estatus_maniobras.";
        }
    } else {
        echo "Error al insertar en ubicaciones_maniobras.";
    }
}
