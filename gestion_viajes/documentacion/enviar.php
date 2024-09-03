<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
require '../../vendor/autoload.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function cargarConfiguracion($ruta)
{
    if (file_exists($ruta)) {
        return json_decode(file_get_contents($ruta), true);
    }
    throw new Exception("Error al cargar configuración desde $ruta");
}

session_start();
$cn = conectar();
$id = $_POST['id'];
$tipo_doc = $_POST['tipo_doc']; // Obtener el tipo de documento
$usuario = $_SESSION['userID'];
$uploadPath = "../adjuntos_estatus/$id/";

if (!is_dir($uploadPath) && !mkdir($uploadPath, 0777, true)) {
    die("Error al crear el directorio $uploadPath");
}

$config = cargarConfiguracion('../../ajustes/configuraciones/GuardarDatosCorreos.json');

$HOST = $config[0];
$PORT = $config[1];
$MAIL = $config[2];
$PASSWOORD = $config[3];
$USERREALNAME = $config[4];

date_default_timezone_set("America/Mexico_City");
$hora = date("Y-m-d H:i:s");

$destinatarios = $cn->query("SELECT REFERENCIA, CORREO FROM correos_viajes
                             INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_viajes.ID_CORREO
                             INNER JOIN viajes ON viajes.ID = correos_viajes.ID_VIAJE
                             WHERE ID_VIAJE = $id AND TIPO = 'Destinatario'");
$cc = $cn->query("SELECT CORREO FROM correos_viajes
                  INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_viajes.ID_CORREO
                  WHERE ID_VIAJE = $id AND TIPO = 'CC'");

$uploadedFiles = [];
if (!empty($_FILES['files'])) {
    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['files']['name'][$key];
        $targetPath = "$uploadPath/$fileName";

        if (move_uploaded_file($tmpName, $targetPath)) {
            $uploadedFiles[] = $fileName;

            // Subir archivo a Odoo
            $fileContent = base64_encode(file_get_contents($targetPath));
            $models->execute_kw($db, $uid, $password, 'ir.attachment', 'create', [[
                'name' => $fileName,
                'datas' => $fileContent,
                'datas_fname' => $fileName,
                'res_model' => 'tms.travel',
                'res_id' => $id
            ]]);
        }
    }
}

if ($tipo_doc === 'eir' && empty($uploadedFiles)) {
    $cn->query("INSERT INTO documentacion VALUES (NULL, $id, '$tipo_doc', 'EIR No solicitado', $usuario, '$hora')");
} else {
    foreach ($uploadedFiles as $uploadedFile) {
        $cn->query("INSERT INTO documentacion VALUES (NULL, $id, '$tipo_doc', '$uploadedFile', $usuario, '$hora')");
    }
}


if (($tipo_doc !== 'cuentaop' && !empty($uploadedFiles)) || ($tipo_doc === 'eir' && !empty($uploadedFiles))) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $MAIL;
        $mail->Password   = $PASSWOORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $PORT;
        $mail->setFrom($MAIL, $USERREALNAME);
        $mail->addReplyTo($MAIL, $USERREALNAME);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Referencia de Viaje: ';
        $mail->Body = 'Envio de ' . $tipo_doc;

        $referencia = '';
        while ($row = $destinatarios->fetch_assoc()) {
            $mail->addAddress($row['CORREO']);
            $referencia = $row['REFERENCIA'];
        }
        while ($row = $cc->fetch_assoc()) {
            $mail->addCC($row['CORREO']);
        }
        $mail->addCC('monitoreo@phi-cargo.com');

        $userEmailResult = $cn->query("SELECT correo FROM usuarios WHERE id_usuario = $usuario");
        if ($userEmailResult && $userEmailResult->num_rows > 0) {
            $mail->addCC($userEmailResult->fetch_assoc()['correo']);
        }

        $mail->addCustomHeader('In-Reply-To', $referencia);
        $mail->addCustomHeader('References', $referencia);
        $mail->Subject .= $referencia;

        foreach ($uploadedFiles as $uploadedFile) {
            $mail->addAttachment("$uploadPath/$uploadedFile", $uploadedFile);
        }

        if ($mail->send()) {
            echo 1;
        } else {
            foreach ($uploadedFiles as $uploadedFile) {
                unlink("$uploadPath/$uploadedFile");
            }
            echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo 1;
}
