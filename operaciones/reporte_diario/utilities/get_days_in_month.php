<?php

function getDaysInMonth(string $date)
{
  $dt = new DateTime($date);
  return $dt->format('t');
}