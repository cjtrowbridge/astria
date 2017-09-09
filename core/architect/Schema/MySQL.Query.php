<?php

function ArchitectSchemaMySQLQuery($Alias){
  global $ASTRIA;
  $Name = $ASTRIA['databases'][$Alias]['database'];
  
  pd($_POST);
  
  if(!(isset($_POST['query']))){
    $Query='SHOW TABLES';
  }else{
    $Query=$_POST['query'];
  }
  
  ?>


  <div class="card">
    <div class="card-block">
      <h4 class="card-title">Query Database: '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $Name; ?></a>'</h4>
      <form action="/architect/schema/<?php echo $Alias; ?>/?query" method="post">
        <textarea class="form-control" name="query" rows="8"><?php echo $Query; ?></textarea><br>
        <input type="submit" class="btn btn-success" value="Run">
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-block">
      <h4 class="card-title">Results</h4>
      <?php echo ArrTabler(Query($Query,$Alias)); ?>
    </div>
  </div>


  <?php
}
