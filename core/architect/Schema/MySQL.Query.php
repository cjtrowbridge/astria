<?php

function ArchitectSchemaMySQLQuery($Alias){
  global $ASTRIA;
  $Name = $ASTRIA['databases'][$Alias]['database'];
  
  if(!(isset($_POST['query']))){
    $Query='SHOW TABLES';
  }else{
    $Query=$_POST['query'];
  }
  
  ?><br>


  <div class="card">
    <div class="card-block">
      <b class="card-title">Query Database: '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $Name; ?></a>'</b><br>
      <form action="/architect/schema/<?php echo $Alias; ?>/?query" method="post">
        <textarea class="form-control" name="query" rows="8"><?php echo $Query; ?></textarea><br>
        <div class="row">
          <div class="col-xs-12 col-md-6">
            <select name="graphResults" class="form-control">
              <option selected>No Graph</option>
              <option value="line">Line</option>
            </select>
          </div>
          <div class="col-xs-12 col-md-6">
            <input type="submit" class="btn btn-success form-control" value="Run">
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-block">
      <b class="card-title">Results</b><br>
      <?php echo ArrTabler(Query($Query,$Alias)); ?>
    </div>
  </div>


  <?php
}
