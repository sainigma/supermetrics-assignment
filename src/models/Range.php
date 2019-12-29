<?php
  class Range{
    public $start;
    public $end;

    public function setRangeByMonth($monthStart, $year, $durationInMonths){
      $this->start = mktime(0,0,0,$monthStart,1,$year);
      $monthEnd = $monthStart+$durationInMonths;
      $yearEnd = $year;
      if( $monthEnd>12 ){
        $yearEnd += floor( $monthEnd/12 );
        $monthEnd -= $monthStart;
      }
      $this->end = mktime(0,0,0,$monthEnd,1,$yearEnd);
    }
  }
?>