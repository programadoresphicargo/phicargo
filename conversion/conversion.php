<?php

function formatear($dateTime)
{
    $dt = new DateTimeImmutable($dateTime, new DateTimeZone('UTC'));
    $local_time = $dt->setTimezone(new DateTimeZone('America/Mexico_city'))->format('Y-m-d H:i:s');

    return $local_time;
}
