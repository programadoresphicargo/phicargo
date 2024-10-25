<?php
function validate_date(string $date, $format = 'Y-m-d'): bool
{
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}
