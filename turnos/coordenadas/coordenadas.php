<?php
require '../../vendor/autoload.php';
require_once "../../mysql/conexion.php";
require_once "../algoritmos/algoritmos.php";
$fecha_actual = date('Y-m-d H:i:s');

$cn = conectar();

use Location\Coordinate;
use Location\Polygon;

// VERACRUZ
$VERACRUZ = new Polygon();

$VERACRUZ->addPoint(new Coordinate(19.22572345509212, -96.19442759868642));
$VERACRUZ->addPoint(new Coordinate(19.22447141349288, -96.19447323326675));
$VERACRUZ->addPoint(new Coordinate(19.224490080939194, -96.1967475774345));
$VERACRUZ->addPoint(new Coordinate(19.2257596901687, -96.19666101597471));

$MANZANILLO = new Polygon();

$MANZANILLO->addPoint(new Coordinate(18.93197864236274, -104.08699733800566));
$MANZANILLO->addPoint(new Coordinate(18.929823118873465, -104.0872872823847));
$MANZANILLO->addPoint(new Coordinate(18.92961747855191, -104.08726071145917));
$MANZANILLO->addPoint(new Coordinate(18.931865438780395, -104.08489132709731));

$MEXICO = new Polygon();

$MEXICO->addPoint(new Coordinate(19.585331249199093, -98.91984911399246));
$MEXICO->addPoint(new Coordinate(19.58443818917613, -98.9200030012974));
$MEXICO->addPoint(new Coordinate(19.584270921331406, -98.91907092350294));
$MEXICO->addPoint(new Coordinate(19.58517068643716, -98.91888528535709));

$MANIOBRAS_VER = new Polygon();

$MANIOBRAS_VER->addPoint(new Coordinate(19.408931898013698, -95.91207656435203));
$MANIOBRAS_VER->addPoint(new Coordinate(19.39275827277487, -96.45118707135661));
$MANIOBRAS_VER->addPoint(new Coordinate(18.938461434568957, -96.43403923760522));
$MANIOBRAS_VER->addPoint(new Coordinate(18.945412540323, -95.75629138721833));

$MANIOBRAS_MANZANILLO = new Polygon();

$MANIOBRAS_MANZANILLO->addPoint(new Coordinate(19.516232002529364, -103.49139950849833));
$MANIOBRAS_MANZANILLO->addPoint(new Coordinate(18.668602460169396, -103.38510996178078));
$MANIOBRAS_MANZANILLO->addPoint(new Coordinate(18.671058471726788, -104.70984065379692));
$MANIOBRAS_MANZANILLO->addPoint(new Coordinate(19.480908831481507, -104.84009041097464));

$GPS = "https://telemetry.apis.motumweb.com/clients/1195/users/48405/assets/current-position?key=AIzaSyDyd9LshxktDkT6KLpmo8iWQa2dhvKnc0A";

function get_data($url)
{
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);

    if (!curl_errno($ch)) {
        return $data;
    } else {
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
}

try {
    $decoded_json = json_decode(get_data($GPS), true);
    $json = json_encode($decoded_json);
    file_put_contents('motum2.json', $json);
    $codigo = $decoded_json['code'];
    $mensaje = $decoded_json['message'];

    $logFile = fopen("log.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n" . date("d/m/Y H:i:s") . " Codigo: " . $codigo . " Mensaje: " . $mensaje) or die("Error escribiendo en el archivo");
    fclose($logFile);
} catch (Exception $e) {
    $logFile = fopen("log.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n" . date("d/m/Y H:i:s") . "ERROR: " . $GPS . ', ERROR: ' . $e->getMessage()) or die("Error escribiendo en el archivo");
    fclose($logFile);
}

function formatear($iso_datetime_str)
{
    $date = new DateTime($iso_datetime_str);
    $timezone = new DateTimeZone('America/Mexico_City');
    $date->setTimezone($timezone);
    return $date->format('Y-m-d H:i:s');
}

echo "Codigo: " . $codigo . "<br>";
echo "Mensaje: " . $mensaje . "<br>";

if ($codigo == '100') {

    $ubicacion     = $decoded_json['data'];
    $codigo        = $decoded_json['code'];
    $mensaje       = $decoded_json['message'];
    $date          = $decoded_json['meta']['queryDate'];
    $transaccion   = $decoded_json['meta']['transactionId'];

    $i = 0;
    foreach ($ubicacion as $ubi) {
        $unidad     = $ubicacion[$i]['vehicleNumber'];
        $placas     = $ubicacion[$i]['numberPlates'];
        $latitud    = $ubicacion[$i]['position']['latitude'];
        $longitud   = $ubicacion[$i]['position']['longitude'];
        $referencia = $ubicacion[$i]['position']['nearestCityReference'];
        $calle      = $ubicacion[$i]['position']['streetReference'];
        $velocidad  = $ubicacion[$i]['position']['gpsSpeed'];
        $dateTime   = $ubicacion[$i]['position']['date'];

        echo $placas . '' . $dateTime . '<br>';

        $fecha_hora = formatear($dateTime);
        $separar = (explode(" ", $fecha_hora));
        $fecha = $separar[0];
        $hora = $separar[1];

        $sqlSelect = "SELECT ESTADO, SALIDA, REGRESO FROM unidades WHERE PLACAS ='$placas'";
        $resultSet = $cn->query($sqlSelect);
        $row = $resultSet->fetch_assoc();

        $COORDENADA = new Coordinate($latitud, $longitud);
        if ($VERACRUZ->contains($COORDENADA)) {

            if ($row['ESTADO'] == 'DENTRO') {
                echo 'UNIDAD: ' . $unidad . ' ' . $placas . ' ' . $latitud . ',' . $longitud . " DENTRO<br>";
            } else {
                if ($fecha_hora <= $fecha_actual) {
                    $sqlInsert = "INSERT INTO ubicaciones VALUES(NULL, '$placas', $latitud, $longitud, '$referencia', '$calle', $velocidad, '$fecha_hora')";
                    if ($cn->query($sqlInsert)) {
                        echo "Registro insertado correctamente.";
                    } else {
                        echo "Error al insertar el registro: " . $cn->error;
                    }
                } else {
                    echo "La fecha y hora proporcionadas son mayores que la fecha y hora actual. No se insertará el registro.";
                }

                if ($row['ESTADO'] == 'FUERA') {
                    $sqlUpdate = "UPDATE unidades SET ESTADO = 'DENTRO', BASE = 'VERACRUZ', REGRESO = '$fecha $hora' WHERE PLACAS ='$placas'";
                    $cn->query($sqlUpdate);
                }

                $resultSet = $cn->query($sqlSelect);
                $row = $resultSet->fetch_assoc();

                if ($row['SALIDA'] != '' && $row['REGRESO'] != '') {
                    $salida  = $row['SALIDA'];
                    $regreso = $row['REGRESO'];
                    $sqlSelect = "SELECT LATITUD, LONGITUD FROM ubicaciones WHERE FECHA_HORA BETWEEN '$salida' AND '$regreso' AND PLACAS ='$placas'";
                    $resultSet = $cn->query($sqlSelect);
                    $salio = false;

                    while (($row2 = $resultSet->fetch_assoc()) && ($salio != true)) {
                        $LAT   = $row2['LATITUD'];
                        $LONG  = $row2['LONGITUD'];
                        $coord = new Coordinate($LAT, $LONG);
                        if ($MANIOBRAS_VER->contains($coord)) {
                            echo "NO SALIO DE VERACRUZ<br>";
                            echo $row2['LATITUD'] . ' , ' . $row2['LONGITUD'] . "DENTRO<br>";
                        } else {
                            $salio = true;
                            echo "SI SALIO DE VERACRUZ<br>";
                            echo $row2['LATITUD'] . ' , ' . $row2['LONGITUD'] . "FUERA<br>";
                            insertar_turno($cn, 0, $placas, $fecha, $hora, NULL, 'veracruz', 8);
                        }
                    }
                }
            }
        } else if ($MANZANILLO->contains($COORDENADA)) {

            if ($row['ESTADO'] == 'DENTRO') {
                echo 'UNIDAD: ' . $unidad . ' ' . $placas . ' ' . $latitud . ',' . $longitud . " DENTRO " . "$fecha_hora" . "<br>";
            } else {
                if ($fecha_hora <= $fecha_actual) {
                    $sqlInsert = "INSERT INTO ubicaciones VALUES(NULL, '$placas', $latitud, $longitud, '$referencia', '$calle', $velocidad, '$fecha_hora')";
                    if ($cn->query($sqlInsert)) {
                        echo "Registro insertado correctamente.";
                    } else {
                        echo "Error al insertar el registro: " . $cn->error;
                    }
                } else {
                    echo "La fecha y hora proporcionadas son mayores que la fecha y hora actual. No se insertará el registro.";
                }

                if ($row['ESTADO'] == 'FUERA') {
                    $sqlUpdate = "UPDATE unidades SET ESTADO = 'DENTRO', BASE = 'MANZANILLO', REGRESO = '$fecha $hora' WHERE PLACAS ='$placas'";
                    $cn->query($sqlUpdate);
                }

                $resultSet = $cn->query($sqlSelect);
                $row = $resultSet->fetch_assoc();

                if ($row['SALIDA'] != '' && $row['REGRESO'] != '') {
                    $salida  = $row['SALIDA'];
                    $regreso = $row['REGRESO'];
                    $sqlSelect = "SELECT LATITUD, LONGITUD FROM ubicaciones WHERE FECHA_HORA BETWEEN '$salida' AND '$regreso' AND PLACAS ='$placas'";
                    $resultSet = $cn->query($sqlSelect);
                    $salio = false;

                    while (($row2 = $resultSet->fetch_assoc()) && ($salio != true)) {
                        $LAT   = $row2['LATITUD'];
                        $LONG  = $row2['LONGITUD'];
                        $coord = new Coordinate($LAT, $LONG);
                        if ($MANIOBRAS_MANZANILLO->contains($coord)) {
                            echo "NO SALIO DE MANZANILLO<br>";
                            echo $row2['LATITUD'] . ' , ' . $row2['LONGITUD'] . "DENTRO<br>";
                        } else {
                            $salio = true;
                            echo "SI SALIO DE MANZANILLO<br>";
                            echo $row2['LATITUD'] . ' , ' . $row2['LONGITUD'] . "FUERA<br>";
                            insertar_turno($cn, 0, $placas, $fecha, $hora, NULL, 'manzanillo', 8);
                        }
                    }
                }
            }
        } else if ($MEXICO->contains($COORDENADA)) {
            if ($row['ESTADO'] == 'DENTRO') {
                echo 'UNIDAD: ' . $unidad . ' ' . $placas . ' ' . $latitud . ',' . $longitud . " DENTRO " . "$fecha_hora" . "<br>";
            } else {
                if ($fecha_hora <= $fecha_actual) {
                    $sqlInsert = "INSERT INTO ubicaciones VALUES(NULL, '$placas', $latitud, $longitud, '$referencia', '$calle', $velocidad, '$fecha_hora')";
                    if ($cn->query($sqlInsert)) {
                        echo "Registro insertado correctamente.";
                    } else {
                        echo "Error al insertar el registro: " . $cn->error;
                    }
                } else {
                    echo "La fecha y hora proporcionadas son mayores que la fecha y hora actual. No se insertará el registro.";
                }

                if ($row['ESTADO'] == 'FUERA') {
                    $sqlUpdate = "UPDATE unidades SET ESTADO = 'DENTRO', BASE = 'MEXICO', REGRESO = '$fecha $hora' WHERE PLACAS ='$placas'";
                    $cn->query($sqlUpdate);
                    insertar_turno($cn, 0, $placas, $fecha, $hora, NULL, 'mexico', 8);
                }
            }
        } else {

            echo 'UNIDAD: ' . $unidad . ' ' . $placas . ' ' . $latitud . ',' . $longitud . " FUERA " . "$fecha_hora" . "<br>";

            if ($row['ESTADO'] == 'DENTRO') {
                $sqlUpdate = "UPDATE unidades SET SALIDA = '$fecha $hora' WHERE PLACAS ='$placas'";
                $cn->query($sqlUpdate);
            }

            $sqlUpdate = "UPDATE unidades SET ESTADO = 'FUERA', REGRESO ='' WHERE PLACAS ='$placas'";
            $cn->query($sqlUpdate);

            $sqlSelect = "SELECT PLACAS, LATITUD, LONGITUD, FECHA_HORA FROM ubicaciones WHERE placas = '$placas' AND latitud = $latitud AND longitud = $longitud AND FECHA_HORA = '$fecha_hora'";
            $resultado = $cn->query($sqlSelect);
            if ($resultado->num_rows == 1) {
            } else {

                if ($fecha_hora <= $fecha_actual) {
                    $sqlInsert = "INSERT INTO ubicaciones VALUES(NULL, '$placas', $latitud, $longitud, '$referencia', '$calle', $velocidad, '$fecha_hora')";
                    if ($cn->query($sqlInsert)) {
                        echo "Registro insertado correctamente.";

                        $lastInsertId = $cn->insert_id;

                        try {
                            $sqlUltimo = "INSERT INTO ultima_ubicacion VALUES ('$placas', $latitud, $longitud, '$fecha_hora','activo')";
                            $cn->query($sqlUltimo);
                        } catch (mysqli_sql_exception $e) {
                            if ($e->getCode() == 1062) {
                                $sqlUpdate = "UPDATE ultima_ubicacion 
                                              SET latitud = $latitud, longitud = $longitud, fecha_hora = '$fecha_hora'
                                              WHERE placas = '$placas'";
                                $cn->query($sqlUpdate);
                            } else {
                                throw $e;
                            }
                        }

                        $sqlBusquedaViaje = "SELECT * FROM viajes where placas = '$placas' and estado IN ('ruta','planta','retorno','resguardo')";
                        $resultadoViaje = $cn->query($sqlBusquedaViaje);
                        $rowViaje = $resultadoViaje->fetch_assoc();
                        if ($resultadoViaje->num_rows == 1) {
                            $id_viaje = $rowViaje['id'];
                        } else {
                            $id_viaje = null;
                        }

                        $logFile = 'log_evento.txt'; // Archivo de log

                        foreach ($ubicacion[$i]['position']['events'] as $event) {
                            $Event = $event['event'];
                            $EventName = $event['eventTypeName'];
                            $EventDescription = $event['eventDescription'];
                            $sqlAlerta = "INSERT INTO alertas VALUES(NULL,'$placas','$Event','$EventName','$EventDescription','$fecha_hora',$id_viaje,$lastInsertId,null,null,null,null)";

                            try {
                                $cn->query($sqlAlerta);
                                $logMessage = "SUCCESS: Query executed successfully.\n";
                                $logMessage .= "Query: $sqlAlerta\n";
                                $logMessage .= "Variables: placas=$placas, Event=$Event, EventName=$EventName, EventDescription=$EventDescription, fecha_hora=$fecha_hora, id_viaje=$id_viaje, lastInsertId=$lastInsertId\n";
                                file_put_contents($logFile, $logMessage, FILE_APPEND);
                            } catch (Exception $e) {
                                $logMessage = "ERROR: Query failed.\n";
                                $logMessage .= "Query: $sqlAlerta\n";
                                $logMessage .= "Variables: placas=$placas, Event=$Event, EventName=$EventName, EventDescription=$EventDescription, fecha_hora=$fecha_hora, id_viaje=$id_viaje, lastInsertId=$lastInsertId\n";
                                $logMessage .= "Exception Message: " . $e->getMessage() . "\n";
                                file_put_contents($logFile, $logMessage, FILE_APPEND);
                            }
                        }
                    } else {
                        echo "Error al insertar el registro: " . $cn->error;
                    }
                } else {
                    echo "La fecha y hora proporcionadas son mayores que la fecha y hora actual. No se insertará el registro.";
                }
            }
        }
        $i++;
    }
}

$sqlSelect9 = "SELECT * from turnos left join operadores on turnos.id_operador = operadores.id left join unidades on turnos.placas = unidades.placas where cola = false and fecha_archivado is null order by sucursal, turno asc";
$resultSet9 = $cn->query($sqlSelect9);
echo "<br>";
while ($row9 = $resultSet9->fetch_assoc()) {
    echo $row9['sucursal'] . '            -                      ' . $row9['turno'] . "              -        " . $row9['nombre_operador'] . "<br>";
    $userData['turnos_veracruz'][] = $row9;
}
