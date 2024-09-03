<?php

function crear_enlance($latitud, $longitud)
{
    $enlace = "https://www.google.com/maps?q=$latitud, $longitud&hl=es-PY&gl=py&shorturl=1";
    return $enlace;
}


function crear_enlance_distancia($latitud, $longitud, $tipo, $codigo_postal, $sucursal)
{
    if ($tipo == 'imp') {
        if ($sucursal = '[VER] Veracruz (Matriz)') {
            $codigo_postal_origen = '91808';
        } else if ($sucursal = '[MZN] Manzanillo (Sucursal)') {
            $codigo_postal_origen = '28219';
        }
    }
    $enlace = "https://www.google.com.mx/maps/dir/$latitud,$longitud/$codigo_postal/";
    return $enlace;
}
