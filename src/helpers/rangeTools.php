<?php

function splitRangeToMonths($totalRange){
  $startMonth = date("m", $totalRange->start);
  $startYear = date("Y", $totalRange->start);
  $ranges = array();
  $months=0;
  $lastTimestamp=0;
  do{
    $range = new Range;
    $range->setRangeByMonth($startMonth+$months,$startYear,1);
    $lastTimestamp = $range->end;
    array_push($ranges,$range);
    $months++;
  } while( $lastTimestamp<$totalRange->end );
  return $ranges;
}

function splitMonthToWeeks($range){
  $ranges = array();
  $previousWeek = (int)date("W",$range->start);
  $monthAtBeginning = (int)date("m",$range->start);
  $currentDate = $range->start;

  while( (int)date("m",$currentDate)==$monthAtBeginning ){
    $range = new Range;
    $range->start = $currentDate;
    while( (int)date("W",$currentDate)==$previousWeek && (int)date("m",$currentDate)==$monthAtBeginning ) $currentDate += 24*3600;
    $previousWeek = (int)date("W",$currentDate);
    $range->end = $currentDate;
    array_push($ranges,$range);
  }
  return $ranges;
}

?>