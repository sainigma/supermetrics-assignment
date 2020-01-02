<?php
  class Range{
    public $start;
    public $end;

    private function fixMonthOverflow($month,$year){
      $result = array($month,$year);
      if($month>12){
        $result[0] = $month % 12;
        $result[1] = $year + floor( $month/12 );
      }
      return $result;
    }

    public function setRangeByMonth($month, $year, $durationInMonths){
      list($monthStart,$yearStart) = $this->fixMonthOverflow($month,$year);
      list($monthEnd,$yearEnd) = $this->fixMonthOverflow($monthStart+$durationInMonths, $yearStart);
      $this->start = mktime(0,0,0,$monthStart,1,$yearStart);
      $this->end = mktime(0,0,0,$monthEnd,1,$yearEnd);
    }
  }
?>