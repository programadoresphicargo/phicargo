<?php
$URL = $_POST['url_aplicacion'];
$USUARIO = $_POST['usuario_aplicacion'];
$CONTRASENA = $_POST['contrasena_aplicacion'];
$BASEDATOS = $_POST['basedatos_aplicacion'];

$miArray = array($URL, $USUARIO, $CONTRASENA, $BASEDATOS);
$JSON = json_encode($miArray);
$bytes = file_put_contents("GuardarCredencialesOdooAplicacion.json", $JSON);
echo 1;
