<?php

function SchemaRouter_RowColumns($Schema, $Table, $Row){
  //TODO add google address autocomplete api
  
  global $ASTRIA;
  $PrimaryKey = $ASTRIA['Session']['Schema'][$Schema][$Table]['PRIMARY KEY'];
  //TODO this could be an update to an existing row
  //TODO or a delete of a row
  //TODO default to returning the row
    //TODO this could be json
    //TODO or the contents of a dom object
  
    //Handle insert posts
    if(
      isset($_GET['insert']) &&
      isset($_POST[$PrimaryKey])
    ){
      include_once('SchemaRouter_RowColumns.Insert_Handler.php');
      SchemaRouter_RowColumns_Insert_Handler($Schema, $Table);
      exit;
    }
  
    //Handle update posts
    if(
      isset($_GET['update']) &&
      isset($_POST[$PrimaryKey])
    ){
      include_once('SchemaRouter_RowColumns.Update_Handler.php');
      SchemaRouter_RowColumns_Update_Handler($Schema, $Table);
      exit;
    }
  
    //TODO make the title be more relevant 
    TemplateBootstrap4($Table.' '.$Row,'SchemaRouter_RowColumns_Fields_BodyCallback("'.$Schema.'", "'.$Table.'", "'.$Row.'");');
    exit;
}

function SchemaRouter_RowColumns_Fields_BodyCallback($Schema, $Table, $Row = 0){
  
  global $ASTRIA;
  $PrimaryKey     = $ASTRIA['Session']['Schema'][$Schema][$Table]['PRIMARY KEY'];
  $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
  $Referencees    = $ASTRIA['Session']['Schema'][$Schema][$Table]['Referencees'];
  $Columns        = $ASTRIA['Session']['Schema'][$Schema][$Table];
  
  
  
  if(isset($_GET['insert'])){
    //We are creating a new record
    $Data = false;
    
  }else{
    //we are showing an existing record. Validate it and get its data.
    
    //make sure the row is an integer or die.
    $TempRow = intval($Row);
    if($TempRow == 0){die('Invalid '.$FirstTextField.': '.$TempRow.'. Must be an integer.');}
    $Row = $TempRow;

    $Data = Query("SELECT * FROM `".Sanitize($Table)."` WHERE `".SANITIZE($Columns['PRIMARY KEY'])."` = ".intval($Row),$Schema); 
    if(!(isset($Data[0]))){
      die('No Record Found For "'.$Table.'" Number "'.$Row.'"');
    }
    $Data = $Data[0];
  }
  
  //display a header
  $DBTitle = $Schema;
  if(isset($ASTRIA['databases'][$Schema]['title'])){$DBTitle = $ASTRIA['databases'][$Schema]['title'];}

  echo '<h1>';
  if($Row != false){
    //TODO
    echo '<div style="float: right;"><a href="#"><i title="View Previous Versions" class="material-icons">history</i></a></div>';
  }
  echo '<a href="/'.$Schema.'">'.$DBTitle.'</a> / <a href="/'.$Schema.'/'.$Table.'">'.$Table.'</a> /  <a href="/'.$Schema.'/'.$Table.'/'.$Row.'">'.$Data[ $FirstTextField ].'</a></h1>'.PHP_EOL;
  
  
  if( count($Referencees)>0 ){
    //display two columns, one for this table, and one for things that have foreign keys referencing it
    echo '<div class="col-xs-12 col-lg-6">'.PHP_EOL;
    
  }else{
    //no foreign keys reference this table. display only one column
    echo '<div class="col-xs-12">'.PHP_EOL;
    
  }
    
  ?>

<div class="card">
  <div class="card-block">
    <div class="card-text">
      <h2><?php echo QualifiedPlural( SpacesBeforeCapitals( $Table ) ); ?></h2>
<?php
  
  if($Row == false){
    echo '<form action="/'.$Schema.'/'.$Table.'/?insert" method="post">'.PHP_EOL;
  }else{
    echo '<form action="/'.$Schema.'/'.$Table.'/?update" method="post">'.PHP_EOL;
  }
  
  //go through all the columns and display a field for them
  foreach($Columns as $Column){
    
    //skip any meta data about the table. we only want to look at the columns which will all have this field.
    if(!isset($Column['IsConstraint'])){continue;}
    
    if($Row != false){
      $FieldValue = $Data[$Column['COLUMN_NAME']];
    }else{
      $FieldValue = '';
    }
    
    //if this is the primary key, display it as text, and include a hidden input field of it, then skip the rest of the loop.
    if($Column['IsConstraint']['PRIMARY KEY'] == true){
      SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue);
      continue;
    }
    
    
    //TODO foreign keys
    //these will be a select2 with search
    
    
    //Check what we need to do with this field. Maybe editable, maybe just viewable, maybe neither.
    if(
      (!( //These columns are never editable
        $Column['COLUMN_NAME'] == 'TimeInserted' ||
        $Column['COLUMN_NAME'] == 'UserInserted' ||
        $Column['COLUMN_NAME'] == 'TimeUpdated' ||
        $Column['COLUMN_NAME'] == 'UserUpdated'
      )) &&
      HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'].'_Edit')
    ){
      
      //switch($Column['DATA_TYPE']){
        //TODO format dates properly
        //case'':
          
          //break;
      //}
      SchemaRouter_RowColumns_Fields_BodyCallback_EditableText($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue);
      
    }elseif(HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'])){
      
      //If the user does not have permission to edit the field, but they do have permission to view the field, then display it as text
      SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue);
      
    }else{
      
      //If the user has neither permission to view or to edit, display an html comment to this effect for verbosity. This can later be removed.
      echo "\n<!--User does not have permission to view or edit field ".$Column['COLUMN_NAME']." in table ".$Table."-->\n";
      
    }
    
  }
  ?>

        <div class="form-group row">
          <div class="col-xs-12">
            <input class="form-control btn btn-block btn-success" type="submit" value="Save Changes">
          </div>
        </div>
      

      </form>
    
    </div>
  </div>
</div>

  <?php
  
  if( count($Referencees)>0 ){
    //display two columns, one for this table, and one for things that have foreign keys referencing it
    echo '</div>'.PHP_EOL.'<div class="col-xs-12 col-lg-6">'.PHP_EOL;
    
    foreach($Referencees as $Table => $Referencee){
      ?>

<div class="card">
  <div class="card-block">
    <div class="card-text">
      <h2><?php echo QualifiedPlural( SpacesBeforeCapitals( $Table ) ); ?></h2>
    </div>
  </div>
</div>

      <?php
    }
    
  }
  ?>

</div><!--end the main column if there is only one, or the second column if there are two-->

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

function SchemaRouter_RowColumns_Fields_BodyCallback_EditablePhone($Label, $Name, $Value = ''){
  ?>

        <div class="form-group row">
          <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-3 col-form-label"><?php echo $Label; ?>:</label>
          <div class="col-xs-12 col-lg-9">
            <input class="form-control" type="tel" value="<?php echo $Value; ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
          </div>
        </div>

  <?php
}
