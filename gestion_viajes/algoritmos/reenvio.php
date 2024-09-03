<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../codigos/cambiar_estado.php');
require_once('metodos.php');
require '../../vendor/autoload.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
date_default_timezone_set('America/Mexico_City');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$cn = conectar();
$id_viaje = $_POST['id'];
$id_status = $_POST['id_status'];
$status_nombre = $_POST['status_nombre'];
$fecha_hora = date('Y-m-d H:i:s');

if (isset($_SESSION['userID'])) {
    $id_usuario = $_SESSION['userID'];
} else {
    $id_usuario = $_POST['id_usuario'];
}

$sqlUsuarioNombre = "SELECT * FROM usuarios where id_usuario = $id_usuario";
$resultNombre = $cn->query($sqlUsuarioNombre);
$rowNombre = $resultNombre->fetch_assoc();
$nombre_usuario = $rowNombre['nombre'];

$comentarios = $_POST['comentarios'] ?? '';

$sqlInfo = "SELECT * FROM viajes WHERE id = $id_viaje";
$resultInfo = $cn->query($sqlInfo);
$rowInfo = $resultInfo->fetch_assoc();
$referencia_viaje = $rowInfo['referencia'];
$referencia_cliente = $rowInfo['referencia_cliente'];
$placas = $rowInfo['placas'];
$modo = $rowInfo['x_modo_bel'];
$estado = $rowInfo['estado'];
$x_reference = $rowInfo['x_reference'];
$x_reference_2 = $rowInfo['x_reference_2'];
$id_reporte = $_POST['id_reporte'];

try {
    $Datos = file_get_contents('../../ajustes/configuraciones/GuardarDatosCorreos.json');
    $config = json_decode($Datos, true);
} catch (Exception $e) {
    die($e->getMessage());
}

$HOST = $config[0];
$PORT = $config[1];
$MAIL = $config[2];
$PASSWORD = $config[3];
$USERREALNAME = $config[4];

date_default_timezone_set("America/Mexico_City");
$fecha_actual = date("Y-m-d H:i:s");

$destinatarios = obtenerDestinatarios($cn, $id_viaje);
$cc = obtenerCC($cn, $id_viaje);

$mail = new PHPMailer(true);

$cn->autocommit(false);
try {
    configurarCorreo($mail, $HOST, $PORT, $MAIL, $PASSWORD, $USERREALNAME, $referencia_viaje, $referencia_cliente, $destinatarios, $cc);

    if (isset($_FILES['file'])) {
        agregarArchivosAdjuntos($mail, $_FILES['file']);
    }

    $ubicacion = obtenerEstatusOperador($cn, $id_reporte);
    $comentario_limpio = strip_tags($comentarios);

    $variables = [
        'referencia_viaje' => $referencia_viaje,
        'placas' => $placas,
        'latitud' => $ubicacion['latitud'],
        'longitud' => $ubicacion['longitud'],
        'referencia' => $ubicacion['localidad'],
        'calle' => $ubicacion['calle'],
        'fecha_hora' => $ubicacion['fecha_hora'],
        'estatus' => $status_nombre,
        'comentarios' => $comentario_limpio,
        'nombre_usuario' => $nombre_usuario
    ];

    if (!is_null($x_reference)) {
        $variables['contenedor_1'] = $x_reference;
    }

    if (!is_null($x_reference_2)) {
        $variables['contenedor_2'] = $x_reference_2;
    }

    $htmlBody = cargarPlantilla('../plantilla/plantilla_estatus.html', $variables);
    $mail->Body = $htmlBody;

    if ($mail->send()) {
        $sqlInsert = "INSERT INTO reenvios_estatus VALUES(NULL,$id_reporte,$id_usuario,'$fecha_hora','$comentario_limpio')";
        $cn->query($sqlInsert);
        echo 1;
    } else {
        echo 0;
    }

    cambiar_estado($id_viaje, $id_status);

    $cn->commit();
} catch (Exception $e) {
    $cn->rollback();
    echo $e->getMessage();
}

function configurarCorreo($mail, $host, $port, $username, $password, $realname, $referencia_viaje, $referencia_cliente, $destinatarios, $cc)
{
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $port;
    $mail->setFrom($username, $realname);
    $mail->addReplyTo($username, $realname);

    foreach ($destinatarios as $row) {
        $mail->addAddress($row['correo']);
    }

    foreach ($cc as $row) {
        $mail->addCC($row['correo']);
    }

    $mail->addCustomHeader('In-Reply-To', (!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje);
    $mail->addCustomHeader('References', (!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje);
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = (!empty($referencia_cliente) ? 'Referencia: ' . $referencia_cliente . ' - ' : '') . 'Viaje: ' . $referencia_viaje;
}

function obtenerEstatusOperador($cn, $id_reporte)
{
    $sql = "SELECT * FROM reportes_estatus_viajes WHERE id_reporte = $id_reporte";
    $result = $cn->query($sql)->fetch_assoc();
    $id_ubicacion = $result['id_ubicacion'];
    $sql2 = "SELECT * FROM ubicaciones_estatus WHERE id_ubicacion = $id_ubicacion";
    return $cn->query($sql2)->fetch_assoc();
}

function agregarArchivosAdjuntos($mail, $files)
{
    if (isset($files['tmp_name'][0]) && !empty($files['tmp_name'][0])) {
        foreach ($files['tmp_name'] as $key => $tmpName) {
            $fileName = $files['name'][$key];
            $mail->addAttachment($tmpName, $fileName);
        }
    }
}
