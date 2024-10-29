<?php

function mounthDateValidator(string $start_date, string $end_date)
{
  $startMonth = date('Y-m', strtotime($start_date));
  $endMonth = date('Y-m', strtotime($end_date));
  return $startMonth !== $endMonth;   
}
