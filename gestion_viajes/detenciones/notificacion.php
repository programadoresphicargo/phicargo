<?php
require_once('funcion.php');

$registros = obtenerNumRegistrosDetenciones();

if (!empty($registros)) {
    echo 1;
} else {
    echo 0;
}
