<?php

function MySQLTableDescribe($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  
  
  ?>
  <br><div>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?csv">Dump to CSV</a>
    <a class="btn btn-outline-success" href="/architect/schema/3<?php echo $Alias; ?>/?query">Query</a>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?show-all">Show All</a>
    <a class="btn btn-outline-success" href="javascript:void(0);" onclick="$('#tableDescription').slideToggle();">Describe</a>  
  </div><br>
  

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
      <h1 class="card-title">'<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $DBName; ?></a>'.'<?php echo $Table; ?>'</h1>
      <div class="card-text">
        <?php 
          if(isset($_GET['show-all'])){
            echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC"));
          }else{
            echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC LIMIT 100"));
          }
        ?>
      </div>
    </div>
  </div>

  <?php
  
  
  
  
  
}