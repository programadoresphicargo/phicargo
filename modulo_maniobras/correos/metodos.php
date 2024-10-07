<?php
require_once('../../mysql/conexion.php');
require_once('../../postgresql/conexion.php');
require_once('getEjecutivo.php');

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Resultado
{
    public $id_ubicacion;
    public $placas;
    public $latitud;
    public $longitud;
    public $referencia;
    public $calle;
    public $velocidad;
    public $fecha_hora;
    public $contenedor;
}

function minutos_transcurridos($fecha_i, $fecha_f)
{
    $minutos = (strtotime($fecha_i) - strtotime($fecha_f)) / 60;
    $minutos = abs($minutos);
    $minutos = floor($minutos);
    return $minutos;
}

function obtener_ubicacion($vehicle_id)
{
    $cn = conectar();
    $sqlVehicle = "SELECT * FROM flota where vehicle_id = $vehicle_id";
    $resultado = $cn->query($sqlVehicle);
    $row = $resultado->fetch_assoc();
    $placas = $row['plates'];

    $SqlSelectUb = "SELECT * FROM ubicaciones where placas = '$placas' order by fecha_hora desc limit 1";
    $result = $cn->query($SqlSelectUb);
    $resultado = new Resultado();

    while ($row2 = $result->fetch_assoc()) {
        $resultado->id_ubicacion = $row2['id'];
        $resultado->placas = $row2['placas'];
        $resultado->latitud = $row2['latitud'];
        $resultado->longitud = $row2['longitud'];
        $resultado->referencia = $row2['referencia'];
        $resultado->calle = $row2['calle'];
        $resultado->velocidad = $row2['velocidad'];
        $resultado->fecha_hora = $row2['fecha_hora'];
    }

    return $resultado;
}

function enviar_correo($id_maniobra, $id_reporte)
{
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
    echo $PORT = $decoded_json[1];
    echo $MAIL = $decoded_json[2];
    echo $PASSWOORD = $decoded_json[3];
    $USERREALNAME = $decoded_json[4];

    $SqlSelectDestinatario = "SELECT correo from maniobras_correos inner join correos_electronicos on correos_electronicos.id_correo = maniobras_correos.id_correo where id_maniobra = $id_maniobra and tipo = 'Destinatario'";
    $resultDestinatario = $cn->query($SqlSelectDestinatario);
    $SqlSelectCC = "SELECT correo from maniobras_correos inner join correos_electronicos on correos_electronicos.id_correo = maniobras_correos.id_correo where id_maniobra = $id_maniobra and tipo = 'CC'";
    $resultCC = $cn->query($SqlSelectCC);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $MAIL;
        $mail->Password   = $PASSWOORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $PORT;
        $mail->setFrom($MAIL, $USERREALNAME);
        $mail->AddReplyTo($MAIL, $USERREALNAME);

        while ($rowDestinatario = $resultDestinatario->fetchAll(PDO::FETCH_ASSOC)) {
            //$mail->addAddress($rowDestinatario['correo'], '');
            //echo $rowDestinatario['correo'];
        }
        while ($rowCC = $resultCC->fetchAll(PDO::FETCH_ASSOC)) {
            //$mail->addCC($rowCC['correo'], '');
            //echo $rowCC['correo'];
        }

        $mail->addCC('desarrollador@phi-cargo.com', '');

        $mail->addCustomHeader('In-Reply-To', 'Actualizacion maniobra de');
        $mail->addCustomHeader('References', 'Actualizacion maniobra de');
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

        foreach ($resultManiobra as $rowManiobra) {
            $template = file_get_contents('../plantilla/plantilla.php');

            $template = str_replace('{{tipo_maniobra}}', htmlspecialchars($rowManiobra['tipo_maniobra']), $template);
            $template = str_replace('{{referencia_cliente}}', htmlspecialchars($rowManiobra['client_order_ref']), $template);
            $template = str_replace('{{contenedores}}', htmlspecialchars($rowManiobra['contenedores']), $template);
            $template = str_replace('{{comentarios_estatus}}', htmlspecialchars($rowManiobra['comentarios_estatus']), $template);
            $template = str_replace('{{latitud}}', htmlspecialchars($rowManiobra['latitud']), $template);
            $template = str_replace('{{longitud}}', htmlspecialchars($rowManiobra['longitud']), $template);
            $template = str_replace('{{referencia}}', htmlspecialchars($rowManiobra['calle']), $template);
            $template = str_replace('{{calle}}', htmlspecialchars($rowManiobra['calle']), $template);
            $template = str_replace('{{fecha}}', htmlspecialchars($rowManiobra['fecha_hora']), $template);
            $template = str_replace('{{unidad}}', htmlspecialchars($rowManiobra['name']), $template);

            echo $template;
        }
        $mail->Body = $template;

        if ($mail->send()) {
            echo 1;
            date_default_timezone_set("America/Mexico_City");
            $ultimoenvio = date("Y-m-d H:i:s");
            $sqlUpdate = "UPDATE maniobras set ultimo_envio = '$ultimoenvio' where id_cp = $id_cp and tipo = '$tipo'";
            if ($cn->query($sqlUpdate)) {
                echo 'Se actualiza ultimo envio';
            } else {
                echo 'No se actualiza ultimo envio';
            }
        } else {
            echo 0;
        }
    } catch (Exception $e) {
        echo '-------------------------' . '<br>';
        echo $e->getMessage() . "<br>";
        echo '-------------------------' . '<br>';
    }
}

function guardar_base_datos($id_maniobra, $placas)
{
    date_default_timezone_set('America/Mexico_City');
    $hora = date('Y-m-d H:i:s');
    $cn = conectar();
    $cn2 = conectarPostgresql();

    $SQL = "SELECT * FROM ubicaciones where placas = '$placas' order by fecha_hora desc limit 1";
    $result = $cn->query($SQL);
    $row = $result->fetch_assoc();

    $latitud = $row['latitud'];
    $longitud = $row['longitud'];
    $referencia = $row['referencia'];
    $calle = $row['calle'];
    $fecha_hora = $row['fecha_hora'];
    $velocidad = $row['velocidad'];
    if ($velocidad >= 1) {
        $id_estatus = 80;
    } else {
        $id_estatus = 81;
    }

    if (preg_match('/\((.*?)\)/', $referencia, $matches)) {
        $comentario = $matches[1];
    } else {
        $comentario = NULL;
    }

    if ($comentario) {
        echo "Comentario: " . $comentario;
    } else {
        echo "No se encontró comentario en los paréntesis.";
        return;
    }


    $insert = "INSERT INTO ubicaciones_maniobras (placas, latitud, longitud, localidad, sublocalidad, calle, codigo_postal, fecha_hora) VALUES('$placas', $latitud, $longitud, '$referencia', '$referencia', '$calle', 0, '$fecha_hora')";
    if ($cn2->query($insert)) {
        $id_ubicacion = $cn2->lastInsertId();
        echo "ID Ubicación: " . $id_ubicacion . '<br>';
        $insert = "INSERT INTO reportes_estatus_maniobras (id_maniobra, id_ubicacion, id_estatus, id_usuario, fecha_hora, comentarios_estatus)VALUES($id_maniobra,$id_ubicacion, $id_estatus,8,'$hora','$comentario')";
        if ($cn2->query($insert)) {
            $id_reporte = $cn2->lastInsertId();
            echo 1;
            enviar_correo($id_maniobra, $id_reporte);
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}
