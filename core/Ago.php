<?php 

function ago($time){
  /*
    Ago accepts any date or time and returns a string explaining how long ago that was.
    For example, "6 days ago" or "8 seconds ago"
  */
  $time=strtotime($time);
  if(($time==0)||(empty($time))){
    return 'Never';
  }
  $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
  $lengths = array("60","60","24","7","4.35","12","10");
  $now = time();
  $difference     = $now - $time;
  $tense         = "ago";
  for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    $difference /= $lengths[$j];
  }
  $difference = round($difference);
  if($difference != 1) {
    $periods[$j].= "s";
  }
  return "$difference $periods[$j] ago";
}
