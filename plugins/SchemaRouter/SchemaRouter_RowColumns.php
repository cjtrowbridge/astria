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
  
  $Data = Query("SELECT * FROM `".Sanitize($Table)."` WHERE `".SANITIZE($Columns['PRIMARY KEY'])."` = ".intval($Row)); 
  if(!(isset($Data[0]))){
    die('No Record Found For "'.$Table.'" Number "'.$Row.'"');
  }
  $Data = $Data[0];
  
  
  //display a header
  echo '<h1>'.$Table.' '.$Row.'</h1>';
  
  //go through all the columns and display a field for them
  foreach($Columns as $Column){
    
    //skip meta data
    if(!isset($Column['IsConstraint'])){
      continue;
    }
    
    //if this is the primary key, display it as text, and include a hidden input field of it, then skip the rest of the loop.
    if($Column['IsConstraint']['PRIMARY KEY'] == true){
      SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $Data[$Column['COLUMN_NAME']]);
      continue;
    }
    
    //TODO foreign keys
    
    //by default, show a text box if they have permission to edit the field, 
    // or else just the contents of the field of they only have permission to view the data, 
    // or else an html comment saying they have permission neither to view or edit the field
    if(HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'].'_Edit')){
      SchemaRouter_RowColumns_Fields_BodyCallback_EditableText($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $Data[$Column['COLUMN_NAME']]);
    }elseif(HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'])){
      SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $Data[$Column['COLUMN_NAME']]);
    }else{
      echo "\n<!--User does not have permission to view or edit field ".$Column['COLUMN_NAME']." in table ".$Table."-->\n";
    }
    //pd($Column);
    //echo '<hr>';
    
  }
  ?>

<div class="form-group row">
  <div class="col-xs-12">
    <input class="form-control btn btn-block btn-success" type="submit" value="Save Changes">
  </div>
</div>


  <?php
  
}

function SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Label, $Name, $Value = ''){
  ?>

<div class="form-group row">
  <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-3 col-form-label"><?php echo $Label; ?>:</label>
  <div class="col-xs-12 col-lg-9">
    <input class="form-control" type="hidden" value="<?php echo $Value; ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
    <?php echo $Value; ?>
  </div>
</div>

  <?php
}

function SchemaRouter_RowColumns_Fields_BodyCallback_EditableText($Label, $Name, $Value = ''){
  ?>

<div class="form-group row">
  <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-3 col-form-label"><?php echo $Label; ?>:</label>
  <div class="col-xs-12 col-lg-9">
    <input class="form-control" type="text" value="<?php echo $Value; ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
  </div>
</div>

  <?php
}
