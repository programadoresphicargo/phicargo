<?php
require_once('../../mysql/conexion.php');
require_once('../../correos/algoritmos/metodos.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

date_default_timezone_set("America/Mexico_City");
$fecha_hora = date("Y-m-d H:i:s");
$cn = conectar();

$id_cp             = $_POST['id'];
$referencia        = $_POST['referencia'];
$tipo              = $_POST['tipo'];
$contenedor        = $_POST['contenedor'];
$id_operador       = $_POST['id_operador'];
$id_status         = $_POST['id_status'];
$latitud           = $_POST['latitud'];
$longitud          = $_POST['latitud'];
$calle             = $_POST['calle'];
$localidad         = $_POST['localidad'];
$sublocalidad      = $_POST['sublocalidad'];
$codigo_postal     = $_POST['codigo_postal'];
$comentarios       = $_POST['comentarios'];
$id_evidencia      = "NULL";

if (isset($_POST['comentarios'])) {
    $comentarios      = $_POST['comentarios'];
} else {
    $comentarios      = '';
}

if (isset($_POST['imagen']) && !empty($_POST['imagen'])) {
    $imagen = $_POST['imagen'];
    $base64Image = $_POST['imagen'];
    $binaryImage = base64_decode($base64Image);
    $fileName = uniqid() . '.jpg';
    $uploadPath = '../../maniobras/archivos/' . $id_cp . '/' . $fileName;
    if (!file_exists('../../maniobras/archivos/' . $id_cp)) {
        mkdir('../../maniobras/archivos/' . $id_cp, 0777, true);
        $fileSaved = file_put_contents($uploadPath, $binaryImage);
    } else {
        $fileSaved = file_put_contents($uploadPath, $binaryImage);
    }
    if ($fileSaved !== false) {
        $sqlInsertEvidencia = "INSERT INTO evidencias VALUES(NULL,'$fileName','$uploadPath','$fecha_hora')";
        $resultadoEvidencia = $cn->query($sqlInsertEvidencia);
        if ($resultadoEvidencia) {
            $id_evidencia = $cn->insert_id;
        } else {
            $id_evidencia = "NULL";
        }
    } else {
        $id_evidencia = "NULL";
    }
} else {
    $id_evidencia = "NULL";
}

$SelectStatus = "SELECT * FROM status where id_status = $id_status";
$resultadoStatus = $cn->query($SelectStatus);
$rowStatus = $resultadoStatus->fetch_assoc();

if ($rowStatus['email'] == true) {

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

    $SqlSelectDestinatario = "SELECT CORREO FROM correos_maniobras INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_maniobras.ID_CORREO WHERE id_cp = $id_cp AND TIPO = 'Destinatario'";
    $resultDestinatario = $cn->query($SqlSelectDestinatario);
    $SqlSelectCC = "SELECT CORREO FROM correos_maniobras INNER JOIN correos_electronicos ON correos_electronicos.ID_CORREO = correos_maniobras.ID_CORREO WHERE id_cp = $id_cp AND TIPO = 'CC'";
    $resultCC = $cn->query($SqlSelectCC);

    $mail = new PHPMailer(true);

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
        while ($rowDestinatario = $resultDestinatario->fetch_assoc()) {
            $mail->addAddress($rowDestinatario['CORREO'], '');
        }
        while ($rowCC = $resultCC->fetch_assoc()) {
            $mail->addCC($rowCC['CORREO'], '');
        }
        $mail->addCC('desarrollador@phi-cargo.com', '');


        $mail->addCustomHeader('In-Reply-To', $referencia);
        $mail->addCustomHeader('References', $referencia);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        if ($tipo == 'Retiro') {
            $mail->Subject = 'Actualización de estatus - Solicitud de transporte: ' . $id_cp . "";
        } else if ($tipo == 'Ingreso') {
            $mail->Subject = 'Actualización de Status - Contenedor:  ' . $contenedor . "";
        }
        $mail->Body    = 'Status: ' . $rowStatus['status'] . "<br>" . 'Ubicación: ' . $latitud . " , " . $longitud . "<br>" . 'Fecha y hora: ' . date('Y/m/d g:ia');
        if ($mail->send()) {
            guardar_status_maniobra($id_cp, $id_operador, $id_status, $latitud, $longitud, $calle, $localidad, $sublocalidad, $codigo_postal, $fecha_hora, $tipo, $comentarios, $id_evidencia);
        };
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    guardar_status_maniobra($id_cp, $id_operador, $id_status, $latitud, $longitud, $calle, $localidad, $sublocalidad, $codigo_postal, $fecha_hora, $tipo, $comentarios, $id_evidencia);
}

if ($id_status == 94) {
    try {
        $sqlReporte = "INSERT INTO reportes VALUES(NULL,NULL,$id_cp,'$comentarios',NULL,'$fecha_hora',NULL,NULL,NULL)";
        $cn->query($sqlReporte);
        $sqlNoti = "INSERT INTO notificaciones VALUES(NULL,'Operador tiene un problema',NULL,$id_cp,'$fecha_hora','estatus operador maniobra')";
        $cn->query($sqlNoti);
    } catch (Exception $e) {
    }
}
