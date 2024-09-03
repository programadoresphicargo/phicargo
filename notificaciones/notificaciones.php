<?php

function enviar_notificacion($title, $body, $nombre)
{

     require_once('../../mysql/conexion.php');
     $cn = conectar();
     $sqlSelect = "SELECT TOKEN FROM operadores WHERE ID = $nombre";
     $result = $cn->query($sqlSelect);
     $row = $result->fetch_assoc();
     $token = $row['TOKEN'];
     $url = 'https://fcm.googleapis.com/fcm/send';
     $api_key = 'AAAAmTBLy2Y:APA91bHB402UwpJwgOpGA7qwuISsoPL8S8Es6NsZMHSFeTenlffDf8MLPHV649a2jb1IUKAenwVLu_SJWSh6jSH86BxHi1gVJHClMuRGGU7BpKQ8vH-9DoYxBDx92fImKfG2jaK_pzgz';
     $fields = array(
          'notification' => array(
               'title' => $title,
               'body' => $body
          ),
          "to" => "$token"
     );
     $headers = array(
          'Content-Type:application/json',
          'Authorization:key=' . $api_key
     );
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     $result = curl_exec($ch);
     curl_close($ch);
     if ($result === FALSE) {
          die(curl_error($ch));
     }
}