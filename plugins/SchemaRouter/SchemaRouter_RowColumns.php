<?php

function SchemaRouter_RowColumns($Schema, $Table, $Row){
  //TODO this could be an update to an existing row
  //TODO or a delete of a row
  //TODO default to returning the row
    //TODO this could be json
    //TODO or the contents of a dom object
    
    //TODO make the title be more relevant 
    TemplateBootstrap4($Table.' '.$Row,'SchemaRouter_RowColumns_Fields_BodyCallback("'.$Schema.'", "'.$Table.'", "'.$Row.'");');
    exit;
}

function SchemaRouter_RowColumns_Fields_BodyCallback($Schema, $Table, $Row){
  
  global $ASTRIA;
  $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
  $Columns        = $ASTRIA['Session']['Schema'][$Schema][$Table];
  
  
  //make sure the row is an integer or die.
  $TempRow = intval($Row);
  if($TempRow == 0){die('Invalid '.$FirstTextField.': '.$TempRow.'. Must be an integer.');}
  $Row = $TempRow;
  
  //display a header
  echo '<h1>'.$Table.' '.$Row.'</h1>';
  
  //go through all the columns and display a field for them
  foreach($Columns as $Column){
    
    //if this is the primary key, display it as text, and include a hidden input field of it.
    if($Column['IsConstraint']['PRIMARY KEY'] == true){
      SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($FirstTextField, $Column['COLUMN_NAME'], '');
    }
    
    pd($Column);
    echo '<hr>';
    
  }
  
}

function SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Label, $Name, $Value = ''){
  ?>

<div class="form-group row">
  <label for="<?php echo $Name; ?>" class="col-2 col-form-label"><?php echo $Label; ?>:</label>
  <div class="col-10">
    <input class="form-control" type="hidden" value="<?php echo $Value; ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
    <?php echo $Value; ?>
  </div>
</div>

  <?php
}
