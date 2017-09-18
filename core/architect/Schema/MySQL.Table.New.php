<?php

function MySQLTableNew($Alias){
  ?>
  
  <form action="/architect/schema/<?php echo $Alias; ?>/table/?new" method="post" class="form">
    <div class="container no-gutters">
      <div class="row no-gutters">
        <div class="col-xs-12">
          <h1>New Table</h1>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-xs-12 col-md-3">
          <p>Object Name: <span class="text-muted">(This is the name of the table. The name of its primary ID will be this, suffixed with ID.)</span></p>
        </div>
        <div class="col-xs-12 col-md-9">
          <input type="text" class="form-control" name="newTableName" id="newTableName" placeholder="Cat">
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-xs-12">
          <p><b>Common Columns:</b></p>
          <p><label><input type="checkbox" name="commonColumnNameVarchar255" value="true"> Name (Size 255)</label></p>
          <p><label><input type="checkbox" name="commonColumnDescriptionText" value="true"> Description (Size 64k)</label></p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-xs-12">
          <input type="submit" class="form-control" value="Create">
        </div>
      </div>
    </div>
  </form>
  <script>
    $('#newTableName').focus();
  </script>
  
  <?php
}
