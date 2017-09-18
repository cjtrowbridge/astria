<?php

function MySQLTableNew($Alias){
  ?>
  <h1>New Table</h1>
  
  <p><b>Convention:</b> A table should be named a singular capitalized noun. It's primary key will then be that followed by "ID".</p>
  
  <form action="/architect/schema/<?php echo $Alias; ?>/table/?new" method="post" class="form">
    <div class="container no-gutters">
      <div class="row no-gutters">
        <div class="col-xs-12 col-md-3">
          <p>Object Name:</p>
        </div>
        <div class="col-xs-12 col-md-9">
          <input type="text" class="form-control" name="newTableName" placeholder="Cat">
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-xs-12">
          <p><b>Common Columns:</b></p>
          <p><label><input type="checkbox" class="form-control" name="commonColumnNameVarchar255" value="true"> Name (Size 255)</label></p>
          <p><label><input type="checkbox" class="form-control" name="commonColumnDescriptionText" value="true"> Description (Size 64k)</label></p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-xs-12">
          <input type="submit" class="form-control" value="Create">
        </div>
      </div>
    </div>
  </form>
  
  <?php
}
