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
              <option<?php if( isset($_POST['graphResults']) && $_POST['graphResults']==''     ){echo ' selected';} ?>>No Graph</option>
              <option<?php if( isset($_POST['graphResults']) && $_POST['graphResults']=='bar'  ){echo ' selected';} ?> value="bar">Bar</option>
              <option<?php if( isset($_POST['graphResults']) && $_POST['graphResults']=='line' ){echo ' selected';} ?> value="line">Line</option>
              <option<?php if( isset($_POST['graphResults']) && $_POST['graphResults']=='pie'  ){echo ' selected';} ?> value="pie">Pie</option>
            </select>
          </div>
          <div class="col-xs-12 col-md-6">
            <input type="submit" class="btn btn-success form-control" value="Run">
          </div>
        </div>
      </form>
    </div>
  </div>

<?php
  
  $Data = Query($Query,$Alias);

  switch($_POST['graphResults']){
    case 'bar':
    case 'pie':
    case 'line':
      ?>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <h4>Visualization</h4>
        <?php echo Visualize($Data,$_POST['graphResults']); ?>
      </div>
    </div>
  </div>

      <?php
      break;
    deafault:
      //do nothing
  }
  
?>

  <div class="card">
    <div class="card-block">
      <b class="card-title">Results</b><br>
      <?php echo ArrTabler($Data); ?>
    </div>
  </div>


  <?php
}
