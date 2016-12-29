<?php

function DebugShowSummary(){
  
  global $DEBUG;
  echo "<h3>Summary:</h3>\n";
  $summary=array(
    array(
      'Total Runtime' => ($DEBUG[(count($DEBUG)-1)]['timestamp']-$DEBUG[0]['timestamp']).'  seconds',
      'Total RAM' => $DEBUG[(count($DEBUG)-1)]['ram'].' megabytes'
    )
  );
  echo ArrTabler($summary);
  echo "<h3>Detail:</h3>\n";
  echo ArrTabler($DEBUG);
  ?>
  <script>$('.tablesorter').tablesorter({widgets: ["zebra", "filter"]});</script>
  <?php 
  
}
