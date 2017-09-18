<?php

function MySQLTableTruncateConfirmed($Alias,$Table){
  die('TODO');
}

function MySQLTableTruncate($Alias,$Table){
  ?>

<div class="container">
  <div class="row no-gutters">
    <div class="col-xs-12">
      <h1>Truncate Table</h1>
      <p>THIS WILL DUMP ALL DATA IN THE TABLE.</p>
      <form action="/architect/schema/<?php echo $Alias; ?>/table/<?php echo $Table; ?>/" method="get">
        <p>Type "truncate" into the box and click submit in order to truncate the table.</p>
        <input class="form-control" type="text name="truncate" id="truncate" autocomplete="off"><br>
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
