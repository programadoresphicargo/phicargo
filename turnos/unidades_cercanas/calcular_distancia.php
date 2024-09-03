<?php
function distanciaEntreCoordenadas($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371;

    $latitud1 = deg2rad($lat1);
    $longitud1 = deg2rad($lon1);
    $latitud2 = deg2rad($lat2);
    $longitud2 = deg2rad($lon2);

    $dLat = $latitud2 - $latitud1;
    $dLon = $longitud2 - $longitud1;

    $a = sin($dLat / 2) * sin($dLat / 2) + cos($latitud1) * cos($latitud2) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distancia = $radioTierra * $c;

    return $distancia;
}
