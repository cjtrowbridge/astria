<?php

function MySQLTableDropConfirmed($Alias,$Table){
  die('TODO');
}

function MySQLTableDrop($Alias,$Table){
  
  
?>
  <div class="container">
  <div class="row no-gutters">
    <div class="col-xs-12">
      <h1>Truncate Table</h1>
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
