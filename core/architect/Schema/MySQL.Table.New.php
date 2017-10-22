<?php

function MySQLTableNew($Alias){
  global $ASTRIA;
  $Name = $ASTRIA['databases'][$Alias]['database'];
  ?>
  
  <form action="/architect/schema/<?php echo $Alias; ?>/table/?new" method="post" class="form">
    <div class="container no-gutters">
      <div class="row no-gutters">
        <div class="col-xs-12">
          
          <h1>New Table on '<a href="/architect/schema/<?php echo $Alias; ?>"><?php echo $Name; ?></a>'</h1>
          <p>Object Name: <span class="text-muted">(This is the name of the table. The name of its primary ID will be this, suffixed with ID.)</span></p>
          <input type="text" class="form-control" name="newTableName" id="newTableName" placeholder="Cat">
          
          <h4>Include Common Columns?</h4>
          <p><label><input type="checkbox" name="commonColumnNameVarchar255" value="true" checked="checked"> Name (Size 255)</label></p>
          <p><label><input type="checkbox" name="commonColumnDescriptionText" value="true" checked="checked"> Description (Size 64k)</label></p>
          <p><label><input type="checkbox" name="commonColumnInsertedModified" value="true" checked="checked"> User Inserted,TimeInserted,UserUpdated,TimeUpdated</label></p>
          
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
