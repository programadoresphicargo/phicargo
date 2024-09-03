<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../plantilla/plantilla_status.php');
require_once('metodos.php');

session_start();

$cn = conectar();
date_default_timezone_set("America/Mexico_City");
$fecha_actual = date("Y-m-d H:i:s");

$id_viaje = $_POST['id'];

$sqlinfo = "SELECT * FROM viajes where id = $id_viaje";
$resinfo = $cn->query($sqlinfo);
$rowInfo = $resinfo->fetch_assoc();

$referencia      = $rowInfo['referencia'];
$placas          = $rowInfo['placas'];
$operador        = $rowInfo['employee_id'];
$id_cliente      = $rowInfo['partner_id'];
$id_usuario         = $_SESSION['userID'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

try {
    $Datos = file_get_contents('../../ajustes/configuraciones/GuardarDatosCorreos.json');
} catch (Exception $e) {
    echo $e->getMessage();
}

$decoded_json = json_decode($Datos, true);
$json = json_encode($decoded_json);

$HOST = $decoded_json[0];
$PORT = $decoded_json[1];
$MAIL = $decoded_json[2];
$PASSWOORD = $decoded_json[3];
$USERREALNAME = $decoded_json[4];

$cn = conectar();

$SqlComprobacionUnidad = "SELECT * from viajes where placas = '$placas' and estado IN ('ruta', 'planta', 'retorno')";
$resultComprobacion = $cn->query($SqlComprobacionUnidad);

$SqlComprobacionOperador = "SELECT * from viajes where employee_id = $operador and estado IN ('ruta', 'planta', 'retorno')";
$resultComprobacionOperador = $cn->query($SqlComprobacionOperador);

if ($resultComprobacion->num_rows == 0) {

    if ($resultComprobacionOperador->num_rows == 0) {

        $mail = new PHPMailer(true);

        $cn->autocommit(false);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = $HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $MAIL;
            $mail->Password   = $PASSWOORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $PORT;
            $mail->setFrom($MAIL, $USERREALNAME);
            $mail->AddReplyTo($MAIL, $USERREALNAME);

            $destinatarios = obtenerDestinatarios($cn, $id_viaje);
            $cc = obtenerCC($cn, $id_viaje);

            foreach ($destinatarios as $row) {
                $mail->addAddress($row['correo']);
            }

            foreach ($cc as $row) {
                $mail->addCC($row['correo']);
            }
            //$mail->addCC('monitoreo@phi-cargo.com', '');

            $mail->addCustomHeader('In-Reply-To', $referencia);
            $mail->addCustomHeader('References', $referencia);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Referencia de Viaje: ' . $referencia . "";
            $body = getPlantilla($referencia, $placas, 'Inicio de ruta :)');
            $mail->Body    = $body;
            if ($mail->send()) {
                $sqlInsert = "UPDATE viajes set estado = 'ruta', fecha_inicio='$fecha_actual', ultimo_envio='$fecha_actual',usuario_inicio=$id_usuario where id = $id_viaje";
                if ($cn->query($sqlInsert)) {
                    $sqlSelect = "SELECT * FROM ubicaciones WHERE placas = '$placas' ORDER BY fecha_hora DESC LIMIT 1";
                    $resultSet = $cn->query($sqlSelect);
                    $row = $resultSet->fetch_assoc();
                    $id_ubicacion = $row['id'];
                    $placas = $row['placas'];
                    $latitud = $row['latitud'];
                    $longitud = $row['longitud'];
                    $ciudad_referencia = $row['referencia'];
                    $calle = $row['calle'];
                    $velocidad = $row['velocidad'];
                    $fecha_hora = $row['fecha_hora'];

                    guardar_status_manual($id_viaje, $placas, 1, 'Inicio de ruta', $id_usuario, $latitud, $longitud, $ciudad_referencia, $ciudad_referencia, $calle, 0, $velocidad, $fecha_hora, 'Unidad iniciando ruta a destino', $fecha_actual, null);
                    cambiar_estado($id_viaje, 1);
                } else {
                    echo 4;
                }
            }
            $cn->commit();
        } catch (Exception $e) {
            $cn->rollback();
            echo 5;
            echo " " . $e->getMessage();
        }
    } else {
        echo 'El operador tiene otro servicio activo, debe finalizarlo para iniciar uno nuevo.';
    }
} else {
    echo 'La unidad tiene otro servicio activo, debe finalizarlo para iniciar uno nuevo.';
}
