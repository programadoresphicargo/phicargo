<?php
require_once('../../mysql/conexion.php');
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

function enviar_correo($id_cp, $tipo, $contenedor, $latitud, $longitud, $referencia, $calle, $fecha, $unidad, $comentarios, $id_status)
{
    $cn = conectar();

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
    $json = json_encode($decoded_json);

    $HOST = $decoded_json[0];
    $PORT = $decoded_json[1];
    $MAIL = $decoded_json[2];
    $PASSWOORD = $decoded_json[3];
    $USERREALNAME = $decoded_json[4];

    $SqlSelectDestinatario = "SELECT correo from correos_maniobras inner join correos_electronicos on correos_electronicos.id_correo = correos_maniobras.id_correo where id_cp = $id_cp and tipo = 'Destinatario'";
    $SqlSelectDestinatario;
    $resultDestinatario = $cn->query($SqlSelectDestinatario);
    $SqlSelectCC = "SELECT correo from correos_maniobras inner join correos_electronicos on correos_electronicos.id_correo = correos_maniobras.id_correo where id_cp = $id_cp and tipo = 'CC'";
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
        $mail->Port       = 587;
        $mail->setFrom($MAIL, $USERREALNAME);
        $mail->AddReplyTo($MAIL, $USERREALNAME);

        while ($rowDestinatario = $resultDestinatario->fetch_assoc()) {
            //$mail->addAddress($rowDestinatario['correo'], '');
            //echo $rowDestinatario['correo'];
        }
        while ($rowCC = $resultCC->fetch_assoc()) {
            //$mail->addCC($rowCC['correo'], '');
            //echo $rowCC['correo'];
        }

        $ejecutivo = getEjecutivo($id_cp);
        $sqlEjecutiva = "SELECT correo FROM usuarios where nombre like '%$ejecutivo%'";
        echo $ejecutivo . '<br>';
        echo $sqlEjecutiva . '<br>';
        $resultadoEjecutivo = $cn->query($sqlEjecutiva);
        if ($resultadoEjecutivo->num_rows > 0) {
            while ($rowEjecutivo = $resultadoEjecutivo->fetch_assoc()) {
                $mail->addCC($rowEjecutivo['correo'], '');
                echo 'Se añadio el correo' . '<br>';
            }
        } else {
            echo 'No se encontro correo' . '<br>';
        }

        $mail->addCC('desarrollador@phi-cargo.com', '');

        $mail->addCustomHeader('In-Reply-To', $contenedor);
        $mail->addCustomHeader('References', $contenedor);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $status_ubicacion = '';
        preg_match('/\((.*?)\)/', $referencia, $matches);

        if (isset($matches[1])) {
            $status_ubicacion = $matches[1];
            echo $status_ubicacion;
        } else {
            echo "No se encontró ningún paréntesis";
        }

        echo '<<-->>';
        echo $tipo;
        echo '<<-->>';

        if ($tipo == 'Ingreso') {
            $mail->Subject = 'Actualización de Status - Contenedor: ' . $contenedor . "";

            $template = file_get_contents('../plantilla/plantilla.php');
            $template = str_replace('{{statusubicacion}}', $status_ubicacion, $template);
            $template = str_replace('{{contenedor}}', $contenedor, $template);
            $template = str_replace('{{latitud}}', $latitud, $template);
            $template = str_replace('{{longitud}}', $longitud, $template);
            $template = str_replace('{{referencia}}', $referencia, $template);
            $template = str_replace('{{calle}}', $calle, $template);
            $template = str_replace('{{fecha}}', $fecha, $template);
            $template = str_replace('{{unidad}}', $unidad, $template);
            $template = str_replace('{{comentarios}}', $comentarios, $template);
        } else if ($tipo == 'Retiro') {

            $mail->Subject = 'Actualización de estatus - Solicitud de transporte:  ' . $id_cp . "";
            $template = file_get_contents('../plantilla/auto.php');
            $template = str_replace('{{statusubicacion}}', $status_ubicacion, $template);
            $template = str_replace('{{contenedor}}', $contenedor, $template);
            $template = str_replace('{{latitud}}', $latitud, $template);
            $template = str_replace('{{longitud}}', $longitud, $template);
            $template = str_replace('{{referencia}}', $referencia, $template);
            $template = str_replace('{{calle}}', $calle, $template);
            $template = str_replace('{{fecha}}', $fecha, $template);
            $template = str_replace('{{unidad}}', $unidad, $template);
            $template = str_replace('{{comentarios}}', $comentarios, $template);
        }

        $sqlSelect = "SELECT * FROM status where id_status = $id_status";
        $resultS = $cn->query($sqlSelect);
        $rowS = $resultS->fetch_assoc();
        $template = str_replace('{{status}}', $rowS['status'], $template);

        $mail->Body = $template;


        if (!empty($_FILES)) {
            foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['file']['name'][$key];
                $file_tmp = $_FILES['file']['tmp_name'][$key];
                $mail->addAttachment($file_tmp, $file_name);
                $carpeta = '../archivos/' . $id_cp . "";
            }
        }


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

            if (!empty($_FILES)) {
                foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
                    if (!is_dir($carpeta)) {
                        if (mkdir($carpeta, 0777, true)) {
                            if (move_uploaded_file($file_tmp, $carpeta . '/' . $file_name . "")) {
                                echo 'Archivo temporal guardado con éxito en ' . $file_name;
                            } else {
                                echo 'Error al guardar el archivo temporal';
                            }
                        } else {
                            echo 'Error al crear la carpeta';
                        }
                    } else {
                        if (is_dir($carpeta)) {
                            if (move_uploaded_file($file_tmp, $carpeta . '/' . $file_name . "")) {
                                echo 'Archivo temporal guardado con éxito en ' . $file_name;
                            } else {
                                echo 'Error al guardar el archivo temporal';
                            }
                        } else {
                            echo 'La carpeta no existe, no se pudo guardar el archivo';
                        }
                    }
                }
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

function guardar_base_datos($id_cp, $tipo, $id_gps, $id_usuario, $id_status, $hora, $comentarios)
{
    $cn = conectar();

    $SQL = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo' and status = 'Activo' order by fecha_inicio desc limit 1";
    $result = $cn->query($SQL);
    $row = $result->fetch_assoc();
    $id_maniobra = $row['id'];

    $SqlInsert = "INSERT INTO status_maniobras VALUES(NULL,$id_maniobra,$id_gps,NULL,$id_status,$id_usuario,'$hora','$comentarios', NULL)";
    if ($cn->query($SqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
}
