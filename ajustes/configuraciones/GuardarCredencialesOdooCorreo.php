<?php
$URL = $_POST['url_correo'];
$USUARIO = $_POST['usuario_correo'];
$CONTRASENA = $_POST['contrasena_correo'];
$BASEDATOS = $_POST['basedatos_correo'];

$miArray = array($URL, $USUARIO, $CONTRASENA, $BASEDATOS);
$JSON = json_encode($miArray);
$bytes = file_put_contents("GuardarCredencialesOdooCorreo.json", $JSON);
echo 1;
