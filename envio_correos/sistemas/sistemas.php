<?php
require_once('../../mysql/conexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require '../../PHPMailer/src/Exception.php';

function enviar_reporte_fallas_correo($id_reporte)
{
    $cn = conectar();
    $SQL = "SELECT * FROM reportes_app left join operadores on operadores.id = reportes_app.id_operador where id_reporte = $id_reporte";
    $resultado = $cn->query($SQL);
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {

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

            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       = $HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = $MAIL;
                $mail->Password   = $PASSWOORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->setFrom($MAIL, $USERREALNAME);
                $mail->AddReplyTo($MAIL, $USERREALNAME);

                $mail->addAddress('desarrollador@phi-cargo.com', '');
                $mail->addAddress('sistemastb@phi-cargo.com', '');
                $referencia =  'Reporte de falla operador: RF.' . $id_reporte;

                $mail->addCustomHeader('In-Reply-To', $referencia);
                $mail->addCustomHeader('References', $referencia);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $referencia;
                $body = 'Operador: ' . $row['nombre_operador'] . '<br>' . 'Comentario: ' . $row['notas_operador'] . '<br>' . 'Fecha creación: ' . $row['fecha_creacion'];
                $mail->Body = $body;

                if ($mail->send()) {
                    //echo 'El correo se ha enviado correctamente.';
                } else {
                    //echo 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                //echo 0;
            }
        }
    }
}
