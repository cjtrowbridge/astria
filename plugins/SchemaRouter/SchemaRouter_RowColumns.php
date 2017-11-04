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
  
  pd($Row);
  
  global $ASTRIA;
  $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
  $Columns        = $ASTRIA['Session']['Schema'][$Schema][$Table];
  
  foreach($Columns as $Column){
    
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
  <label for="<?php echo $Name; ?>" class="col-2 col-form-label"><?php echo $Caption; ?></label>
  <div class="col-10">
    <input class="form-control" type="hidden" value="<?php echo $Value; ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
    <?php echo $Value; ?>
  </div>
</div>

  <?php
}
