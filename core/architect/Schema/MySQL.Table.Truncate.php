<?php

function MySQLTableTruncateConfirmed($Alias,$Table){
  if(!(IsValidTable($Table))){
   die('Invalid Table'); 
  }
  Query("TRUNCATE ".$Table,$Alias);
  header('Location: /architect/schema/'.$Alias);
  exit;
}

function MySQLTableTruncate($Alias,$Table){
  global $ASTRIA;
  ?>

<div class="container">
  <div class="row no-gutters">
    <div class="col-xs-12">
      <h1><a href="/architect">Architect</a> / <a href="/architect/schema">Schema</a> / '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $ASTRIA['databases'][$Alias]['database']; ?></a>' TRUNCATE '<?php echo $Table; ?>'</h1> 
      <p>THIS WILL DUMP ALL DATA IN THE TABLE.</p>
      <form action="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/" method="post">
        <p>Type "truncate" into the box and click submit in order to truncate the table.</p>
        <input class="form-control" type="text" name="truncate" id="truncate" autocomplete="off"><br>
        <input type="submit" class="btn btn-block btn-danger">
      </form>
    </div>
  </div>
</div>
<script>
  $('#truncate').focus();
</script>

<?php
}
