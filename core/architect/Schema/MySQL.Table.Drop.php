<?php

function MySQLTableDropConfirmed($Alias,$Table){
  Query("DROP ".$Table,$Alias);
  header('Location: /architect/schema/'.$Alias);
  exit;
}

function MySQLTableDrop($Alias,$Table){
  global $ASTRIA;
?>
  <div class="container">
  <div class="row no-gutters">
    <div class="col-xs-12">
      <h1><a href="/architect">Architect</a> / <a href="/architect/schema">Schema</a> / '<a href="/architect/schema/<?php echo $Alias; ?>/"><?php echo $ASTRIA['databases'][$Alias]['database']; ?></a>' DROP '<?php echo $Table; ?>'</h1> 
      <p>THIS WILL DROP THE TABLE.</p>
      <form action="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/" method="post">
        <p>Type "drop" into the box and click submit in order to drop the table.</p>
        <input class="form-control" type="text" name="drop" id="drop" autocomplete="off"><br>
        <input type="submit" class="btn btn-block btn-danger">
      </form>
    </div>
  </div>
</div>
<script>
  $('#drop').focus();
</script>
  <?php
}
