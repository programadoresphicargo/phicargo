<?php

function calcularDistanciaYTiempo($latitud1, $longitud1, $latitud2, $longitud2)
{
    $radioTierra = 6371; // Radio promedio de la Tierra en kilómetros
    $velocidadPromedio = 50; // Velocidad promedio del vehículo en km/h

    $latitud1Rad = deg2rad($latitud1);
    $longitud1Rad = deg2rad($longitud1);
    $latitud2Rad = deg2rad($latitud2);
    $longitud2Rad = deg2rad($longitud2);

    $deltaLatitud = $latitud2Rad - $latitud1Rad;
    $deltaLongitud = $longitud2Rad - $longitud1Rad;

    $a = sin($deltaLatitud / 2) * sin($deltaLatitud / 2) + cos($latitud1Rad) * cos($latitud2Rad) * sin($deltaLongitud / 2) * sin($deltaLongitud / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distanciaKm = $radioTierra * $c; // Distancia en kilómetros

    $tiempoHoras = $distanciaKm / $velocidadPromedio; // Tiempo en horas

    return array(
        'distancia_km' => $distanciaKm,
        'tiempo_horas' => $tiempoHoras
    );
}


function calcular_distancia($placas, $codigo_postal, $estado, $sucursal)
{

    require_once('../../mysql/conexion.php');
    $cn = conectar();
    $sqlSelect = "SELECT latitud, longitud FROM ultima_ubicacion where placas = '$placas' order by fecha_hora desc limit 1";
    $resultado = $cn->query($sqlSelect);
    $row = $resultado->fetch_assoc();
    $latitud1 =  $row['latitud'];
    $longitud1 = $row['longitud'];

    if ($estado == 'retorno') {
        if ($sucursal == '[VER] Veracruz (Matriz)') {
            $codigo_postal = '91810';
        } else {
            $codigo_postal = '28230';
        }
    }

    $sqlSelect2 = "SELECT latitud, longitud FROM codigos_postales where codigo = '$codigo_postal'";
    $resultado2 = $cn->query($sqlSelect2);
    if ($resultado2->num_rows > 0) {
        $row2 = $resultado2->fetch_assoc();
        $latitud2 = $row2['latitud'];
        $longitud2 = $row2['longitud'];
        $resultado = calcularDistanciaYTiempo($latitud1, $longitud1, $latitud2, $longitud2);

        $distancia =  round($resultado['distancia_km'], 2);
        $tiempo =   round($resultado['tiempo_horas'], 2);

        $html = '<span class="badge bg-success text-center">';
        $html .= $distancia . ' km' . '<br>';
        $html .= $tiempo . ' horas';
        $html .= '<span class="badge bg-success">';
        $html .= "<a href='https://www.google.com.mx/maps/dir/$latitud1,$longitud1/$latitud2,$longitud2/' target='_blank' class='link link-dark'>Ver en Maps</a>";

        return $html;
    } else {
        echo "Codigo postal" . "<br>" . " desconocido: " . '<br>' . $codigo_postal;
    }
}
