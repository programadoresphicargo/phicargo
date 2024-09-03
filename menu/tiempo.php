<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'phicargo_sistemastb@outlook.com';
    $mail->Password = 'choforo3d';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del remitente y destinatario
    $mail->setFrom('phicargo_sistemastb@outlook.com', 'Tu Nombre');
    $mail->addAddress('desarrollador@phi-cargo.com', 'Nombre Destinatario');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';
    $mail->Body = 'Este es el contenido del correo HTML.';
    $mail->AltBody = 'Este es el contenido del correo en texto plano.';

    // Enviar el correo
    $mail->send();
    echo 'El correo se ha enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
