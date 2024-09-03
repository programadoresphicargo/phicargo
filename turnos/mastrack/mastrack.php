<?php

use Symfony\Component\Routing\Alias;

require_once('../../mysql/conexion.php');
$cn = conectar();

$url = 'https://swservicios.mastrack.com.mx/Unidades/LocalizarUnidades/';
$postData = array(
    'LocalizarUnidades' => array(
        'sUsuario' => 'c3854sistemas',
        'sPassword' => 'SysTem$20#',
        'sGrupos' => '',
        'sSeries' => 'todas',
        'sAlias' => '',
        'bGeocercas' => false,
        'sGeocercas' => '',
        'sGeocercasCategorias' => '',
        'sGeocercasSubcategorias' => '',
        'sGeocercasClasificaciones' => '',
        'sGeocercasSubclasificaciones' => '',
        'bCompania' => true
    )
);

$jsonData = json_encode($postData);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error en la petición: ' . curl_error($ch);
} else {
    'Respuesta de la API: ' . $response;
    $data = json_decode($response, true);
    file_put_contents('archivo.json', $response);

    $status_code = $data['LocalizarUnidades']['Estatus']['Code'];
    "Status Code: " . $status_code . "<br>";
    if ($status_code == 200) {
        $units = $data['LocalizarUnidades']['Unidades'];

        foreach ($units as $unit) {
            $unidad = $unit['Alias'];
            $latitud = $unit['Latitud'];
            $longitud = $unit['Longitud'];
            $direccion = $unit['Direccion'];
            $placas = $unit['Placas'];
            echo $placas . '<br>';
            $velocidad_full = $unit['Velocidad'];
            preg_match('/[\d\.]+/', $velocidad_full, $matches);
            $velocidad = $matches[0];

            $fecha_hora = $unit['FechaHora'];
            if ($fecha_hora != '-1') {
                $fecha_obj = DateTime::createFromFormat('d-m-Y H:i:s', $fecha_hora);
                $fecha_nueva = $fecha_obj->format('Y-m-d H:i:s');
                if ($unidad == 'C-0071' || $unidad == 'C-0075') {
                    try {
                        $sql_select = "SELECT COUNT(*) AS count FROM ubicaciones WHERE placas = '$placas' AND latitud = $latitud AND longitud = $longitud AND fecha_hora = '$fecha_nueva'";
                        $result = $cn->query($sql_select);
                        $row = $result->fetch_assoc();

                        if ($row['count'] == 0) {
                            $sql_insert = "INSERT INTO ubicaciones VALUES(NULL, '$placas', $latitud, $longitud, '$direccion', '', $velocidad, '$fecha_nueva')";
                            if ($cn->query($sql_insert)) {
                                echo 'Ingresado ' . $placas . '<br>';

                                $sqlUltimo = "UPDATE ultima_ubicacion set latitud = $latitud, longitud = $longitud where placas = '$placas'";
                                $cn->query($sqlUltimo);
                            } else {
                                echo 'Error' . '<br>';
                            }
                        } else {
                            echo 'Los datos ya están registrados: ' . $unidad . '<br>';
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            } else {
                echo 'Formato de fecha invalido: ' . $unidad . '<br>';
            }
        }
    } else {
        'echo' . $status_code;
    }
}

curl_close($ch);
?>
<script>
    function recargarPagina() {
        location.reload();
        console.log('ahs');
    }

    setInterval(recargarPagina, 60000);
</script>