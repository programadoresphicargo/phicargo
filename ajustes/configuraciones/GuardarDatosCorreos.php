<?php
$HOST = $_POST['MailHost'];
$PORT = $_POST['MailPort'];
$USER = $_POST['Mail'];
$PASSWOORD = $_POST['MailPasswoord'];
$NAME = $_POST['NameRealUser'];

$miArray = array($HOST, $PORT, $USER, $PASSWOORD, $NAME);
$JSON = json_encode($miArray);
$bytes = file_put_contents("GuardarDatosCorreos.json", $JSON);
echo 1;
