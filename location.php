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

$MANZANILLO = new Polygon();

$MANZANILLO->addPoint(new Coordinate(18.927288, -104.078503));
$MANZANILLO->addPoint(new Coordinate(18.930333, -104.082891));
$MANZANILLO->addPoint(new Coordinate(18.928425, -104.084296));
$MANZANILLO->addPoint(new Coordinate(18.925380, -104.079157));

$placas = '03AY9J';
$sqlSelect = "SELECT * FROM ubicaciones where placas = '$placas' order by fecha_hora desc limit 1";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    //19.225143635598172, -96.1955761728437
    $COORDENADA = new Coordinate(19.225143635598172,-96.1955761728437);
    if ($VERACRUZ->contains($COORDENADA)) {
        echo 1;
    } else {
        if ($MANZANILLO->contains($COORDENADA)) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
