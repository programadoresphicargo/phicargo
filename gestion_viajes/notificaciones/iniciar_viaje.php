<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sqlSelectV = "SELECT * FROM viajes where id = $id_viaje";
$sqlResultadoV = $cn->query($sqlSelectV);
$row2 = $sqlResultadoV->fetch_assoc();
$id_operador = $row2['employee_id'];

$sqlSelect = "SELECT token FROM operadores WHERE id = $id_operador";
$result = $cn->query($sqlSelect);
$row = $result->fetch_assoc();
$targetToken = $row['token'];

$serverKey = 'AAAAmTBLy2Y:APA91bHB402UwpJwgOpGA7qwuISsoPL8S8Es6NsZMHSFeTenlffDf8MLPHV649a2jb1IUKAenwVLu_SJWSh6jSH86BxHi1gVJHClMuRGGU7BpKQ8vH-9DoYxBDx92fImKfG2jaK_pzgz';

$data = [
    'to' => $targetToken,
    'notification' => [
        'title' => 'Viaje asignado',
        'body' => 'Tienes un viaje activo para enviar estatus',
    ],
];

$headers = [
    'Authorization: key=' . $serverKey,
    'Content-Type: application/json',
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
curl_close($ch);

echo $response; // Esto mostrará la respuesta de FCM
