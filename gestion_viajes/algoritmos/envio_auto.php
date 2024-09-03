<?php
require_once('../../mysql/conexion.php');
require_once('metodos.php');
require '../../vendor/autoload.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Mexico_City');
$hora = date('Y-m-d H:i:s');
$cn = conectar();

function minutos_transcurridos($fecha_i, $fecha_f)
{
    return abs(floor((strtotime($fecha_i) - strtotime($fecha_f)) / 60));
}

try {
    $Datos = file_get_contents('../../ajustes/configuraciones/GuardarDatosCorreos.json');
    $config = json_decode($Datos, true);
    list($HOST, $PORT, $MAIL, $PASSWORD, $USERREALNAME) = $config;
} catch (Exception $e) {
    echo "Error loading configuration: " . $e->getMessage();
    exit;
}

$sqlSelect = "SELECT * FROM viajes WHERE estado IN ('ruta', 'planta', 'retorno')";
//$sqlSelect = "SELECT * FROM viajes WHERE referencia = 'V-40630'";
$resultViajes = $cn->query($sqlSelect);

while ($rowViajes = $resultViajes->fetch_assoc()) {
    $id_viaje = $rowViajes['id'];
    $referencia_viaje = $rowViajes['referencia'];
    $referencia_cliente = $rowViajes['referencia_cliente'];
    $estado = $rowViajes['estado'];
    $placas = $rowViajes['placas'];
    $ultimo_envio = $rowViajes['ultimo_envio'];
    $modo = $rowViajes['x_modo_bel'];
    $x_reference = $rowViajes['x_reference'];
    $x_reference_2 = $rowViajes['x_reference_2'];

    if (minutos_transcurridos($ultimo_envio, $hora) > 59) {

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $HOST;
            $mail->SMTPAuth = true;
            $mail->Username = $MAIL;
            $mail->Password = $PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
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

            $mail->addCustomHeader((!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje);
            $mail->addCustomHeader((!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje);
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = (!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje;

            $resultUbicacion = $cn->query("SELECT * FROM ubicaciones WHERE placas = '$placas' ORDER BY fecha_hora DESC LIMIT 1");
            $ubicacion = $resultUbicacion->fetch_assoc();

            $id_status = devolver_status($id_viaje, $estado, $modo, $ubicacion['velocidad']);

            $resultStatus = $cn->query("SELECT status FROM status WHERE id_status = $id_status");
            $status_nombre = $resultStatus->fetch_assoc()['status'];

            $variables = [
                'referencia_viaje' => $referencia_viaje,
                'placas' => $placas,
                'latitud' => $ubicacion['latitud'],
                'longitud' => $ubicacion['longitud'],
                'referencia' => $ubicacion['referencia'],
                'calle' => $ubicacion['calle'],
                'fecha_hora' => $ubicacion['fecha_hora'],
                'estatus' => $status_nombre,
                'comentarios' => '',
                'nombre_usuario' => 'Asistente virtual'
            ];

            if (!is_null($x_reference)) {
                $variables['contenedor_1'] = $x_reference;
            }

            if (!is_null($x_reference_2)) {
                $variables['contenedor_2'] = $x_reference_2;
            }

            $htmlBody = cargarPlantilla('../plantilla/plantilla_estatus.html', $variables);
            $mail->Body = $htmlBody;

            if (($estado == 'retorno' && $modo == 'imp')) {
                echo 'Va a guardar sin enviar por correo.' . '<br>';
            } else {
                echo 'Enviando por correo' . '<br>';
                $mail->send();
            }

            guardar_status_manual($id_viaje, $placas, $id_status, $status_nombre, 8, $ubicacion['latitud'], $ubicacion['longitud'], $ubicacion['referencia'], $ubicacion['referencia'], $ubicacion['calle'], 0, $ubicacion['velocidad'], $ubicacion['fecha_hora'], '', $hora, null);
        } catch (Exception $e) {
            echo 'Error en el envio del mensaje' . "<br>" . $e->getMessage() . "<br>";
            file_put_contents("log.txt", "\n" . date("d/m/Y H:i:s") . " ERROR: " . $e->getMessage(), FILE_APPEND);
        }
    } else {
        echo 'NO HAN PASADO MAS DE 59 MINUTOS VIAJE: ' . $referencia_viaje . "<br>";
    }
}
