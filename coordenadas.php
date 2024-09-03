<?php
require 'vendor/autoload.php';
require_once "mysql/conexion.php";

$cn = conectar();

use Location\Coordinate;
use Location\Polygon;

// VERACRUZ
$VERACRUZ = new Polygon();

$VERACRUZ->addPoint(new Coordinate(19.22572345509212, -96.19442759868642));
$VERACRUZ->addPoint(new Coordinate(19.22447141349288, -96.19447323326675));
$VERACRUZ->addPoint(new Coordinate(19.224490080939194, -96.1967475774345));
$VERACRUZ->addPoint(new Coordinate(19.2257596901687, -96.19666101597471));

$coord = new Coordinate(1, 1);
if ($VERACRUZ->contains($coord)) {
    echo "NO SALIO DE VERACRUZ<br>";
} else {
    $salio = true;
    echo "SI SALIO DE VERACRUZ<br>";
}
