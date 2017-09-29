<?php

function MySQLTableDescribe($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  ?><h1><A href="/architect">Architect</a> / <a href="/architect/schema">Schema</a> / '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $DBName; ?></a>'.'<?php echo $Table; ?>'</h1>  
  

  <br><p>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?csv">Dump to CSV</a>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/?query">Query</a>
    <a class="btn btn-outline-success" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?show-all">Show All</a>
    
    <a class="btn btn-outline-warning" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?add-column">Add Column</a>
    <a class="btn btn-outline-warning" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?remove-column">Remove Column</a>
    
    <a class="btn btn-outline-danger" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?truncate">Truncate</a>
    <a class="btn btn-outline-danger" href="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/?drop">Drop Table</a>
  </p>
  

  <div class="card" id="tableDescription">
    <div class="card-block">
      <div class="card-text">
        <?php 
          $SQL='DESCRIBE `'.Sanitize($Table).'`';
          echo '<pre>'.$SQL.'</pre>';
          $Description = Query($SQL,$Alias);
          echo ArrTabler($Description); 
        ?>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php 
          if(isset($_GET['show-all'])){
            $SQL="SELECT * FROM `".$Table."` ORDER BY 1 DESC";
          }else{
            $SQL="SELECT * FROM `".$Table."` ORDER BY 1 DESC LIMIT 100";
          }
  
          echo '<pre>'.$SQL.'</pre>';
          echo ArrTabler(Query($SQL));
        ?>
      </div>
    </div>
  </div>

  <?php
  
}
