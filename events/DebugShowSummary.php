<?php

function DebugShowSummary(){
  
  global $DEBUG;
  echo "<h3><br>Debug Summary</h3>\n";
  $summary=array(
    array(
      'Total Runtime' => ($DEBUG[(count($DEBUG)-1)]['time']-$DEBUG[0]['time']).'  seconds',
      'Total Memory Consumption' => $DEBUG[(count($DEBUG)-1)]['memory usage'].' megabytes'
    )
  );
  ArrTabler($summary);
  echo '<h3>Debug Detail:</h3>';
  ArrTabler($DEBUG);
  ?>
  <script>$('.tablesorter').tablesorter({widgets: ["zebra", "filter"]});</script>
  <?php 
  
}
