<?php

function MySQLDescribeTable($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  
  
  ?>
  <p>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $DBName; ?>/table/<?php echo $Table; ?>/?csv">Dump to CSV</a>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $DBName; ?>/table/<?php echo $Table; ?>/?show-all">Show All</a>
    <a class="btn btn-outline-success" href="javascript:void(0);" onclick="$('#tableDescription').slideToggle();">Describe</a>  
  </p>
  

  <div class="card" id="tableDescription" style="display: none;">
    <div class="card-block">
      <h2 class="card-title">Table Structure Description</h2>
      <div class="card-text">
        <?php 
          $Description = Query('DESCRIBE `'.Sanitize($Table).'`',$Alias);
          echo ArrTabler($Description); 
        ?>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-block">
      <h1 class="card-title">'<?php echo $DBName; ?>'.'<?php echo $Table; ?>'</h1>
      <div class="card-text">
        <?php 
          echo ArrTabler($Description); 
        ?>
      </div>
    </div>
  </div>

  <?php
  
  
  if(isset($_GET['show-all'])){
    echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC"));
  }else{
    echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC LIMIT 100"));
  }
  
  
}
