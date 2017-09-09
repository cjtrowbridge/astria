<?php

function MySQLDescribeTable($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  $Description = Query('DESCRIBE `'.Sanitize($Table).'`',$Alias);
  
  echo '<h1>Database: '." '".$DBName."'.'".$Table."' </h1>";
  
  ?>
  <div>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $DBName; ?>/table/<?php echo $Table; ?>/?csv">Dump to CSV</a>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $DBName; ?>/table/<?php echo $Table; ?>/?show-all">Show All</a>
    <a class="btn btn-outline-success" href="javascript:void(0);" onclick="$('#tableDescription').slideToggle();">Show Description</a>  
  </div><br>
  

  <div class="card" id="tableDescription" style="display: none;">
    <div class="card-block">
      <h2 class="card-title">Description</h2>
      <div class="card-text">
        <?php echo ArrTabler($Description); ?>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-block">
      <h1 class="card-title">Database: '<?php echo $DBName; ?>'.'<?php echo $Table; ?>'</h1>
      <div class="card-text">
        <?php echo ArrTabler($Description); ?>
      </div>
    </div>
  </div>

  <?php
  
  
  echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC"));
  
}
