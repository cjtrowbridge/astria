<?php

function SchemaRouter_RowColumns($Schema, $Table, $Row){
  //TODO add google address autocomplete api
  
  global $ASTRIA;
  $PrimaryKey     = $ASTRIA['Session']['Schema'][$Schema][$Table]['PRIMARY KEY'];
  $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
  //TODO this could be an update to an existing row
  //TODO or a delete of a row
  //TODO default to returning the row
    //TODO this could be json
    //TODO or the contents of a dom object
  
    //Handle deletes
    if(
      isset($_GET['delete']) &&
      intval($_GET['delete']) != 0
    ){
      Event('Calling Delete Handler...');
      Query("DELETE FROM `".Sanitize($Table)."` WHERE `".Sanitize($PrimaryKey)."` = ".intval($_GET['delete']) ,$Schema);
      header('Location: /'.$Schema.'/'.$Table);
      exit;
    }else{
      Event('No Delete To Handle:');
    }
  
    //Handle insert posts
    if(
      isset($_GET['insert']) &&
      isset($_POST[$FirstTextField])
    ){
      Event('Calling Insert Handler...');
      include_once('SchemaRouter_RowColumns.Insert_Handler.php');
      SchemaRouter_RowColumns_Insert_Handler($Schema, $Table);
      exit;
    }else{
      Event('No Insert To Handle:');
      if(isset($_GET['verbose'])){
        pd($_POST);
      }
    }
  
    //Handle update posts
    if(
      isset($_GET['update']) &&
      isset($_POST[$PrimaryKey])
    ){
      Event('Calling Update Handler...');
      include_once('SchemaRouter_RowColumns.Update_Handler.php');
      SchemaRouter_RowColumns_Update_Handler($Schema, $Table);
      exit;
    }else{
      Event('No Update To Handle:');
      if(isset($_GET['verbose'])){
        pd($_POST);
      }
    }
  
    global $SchemaRouter_RowData, $ASTRIA;
    $PrimaryKey     = $ASTRIA['Session']['Schema'][$Schema][$Table]['PRIMARY KEY'];
    $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
    $Referencees    = $ASTRIA['Session']['Schema'][$Schema][$Table]['Referencees'];
    $Columns        = $ASTRIA['Session']['Schema'][$Schema][$Table];
  
    if(intval($Row)==0){
      $SchemaRouter_RowData = false;
    }else{

      //make sure the row is an integer or die.
      $TempRow = intval($Row);
      if($TempRow == 0){die('Invalid '.$FirstTextField.': '.$TempRow.'. Must be an integer.');}
      $Row = $TempRow;

      $Data = Query("SELECT * FROM `".Sanitize($Table)."` WHERE `".SANITIZE($Columns['PRIMARY KEY'])."` = ".intval($Row),$Schema); 
      if(!(isset($Data[0]))){
        die('No Record Found For "'.$Table.'" Number "'.$Row.'"');
      }
      $SchemaRouter_RowData = FieldMask( $Data[0] );
    
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
    global $SchemaRouter_RowData;
    $Data = $SchemaRouter_RowData;
    
  }
  
  //display a header
  $DBTitle = $Schema;
  if(isset($ASTRIA['databases'][$Schema]['title'])){$DBTitle = $ASTRIA['databases'][$Schema]['title'];}

  echo '<h1>';
  if($Row != false){
    //TODO
    ?>
      <div style="float: right;">
        <a href="javascript:void(0);" onclick="AstriaToggleEditable();"><i class="material-icons">edit</i></a> 
        <a href="#"><i title="View Previous Versions" class="material-icons">history</i></a> 
        <a href="javascript:void(0);" onclick="$('.tableMeta').slideToggle('fast');"><i class="material-icons">info_outline</i></a> 
        <a href="javascript:void(0);" onclick="$('#deleteEntry').slideDown();"><i class="material-icons">delete</i></a>
      </div>
      <style>
        .AstriaToggleEditableInputs{
          display: none;
        }
      </style>
    <?php
  }else{
    ?>
      <style>
        .AstriaToggleEditableLabels{
          display: none;
        }
      </style>
    <?php
  }
  echo '<a href="/'.$Schema.'">'.$DBTitle.'</a> / <a href="/'.$Schema.'/'.$Table.'">'.$Table.'</a> /  <a href="/'.$Schema.'/'.$Table.'/'.$Row.'">'.$Data[ $FirstTextField ].'</a></h1>'.PHP_EOL;
  
  if( 
    count($Referencees)>0 && 
    $Data != false
  ){
    //display two columns, one for this table, and one for things that have foreign keys referencing it
    echo '<div class="col-xs-12 col-lg-6">'.PHP_EOL;
    
  }else{
    //no foreign keys reference this table. display only one column
    echo '<div class="col-xs-12">'.PHP_EOL;
    
  }
    
  ?>

<div class="card" id="deleteEntry" style="display: none;">
  <div class="card-block">
    <div class="card-text">
      <p>Are you sure you want to delete this record?</p>
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <a href="javascript:void(0);" onclick="$('#deleteEntry').slideUp();" class="btn btn-block btn-danger">No</a>
        </div>
        <div class="col-xs-12 col-md-6">
          <a href="<?php echo '/'.$Schema.'/'.$Table.'/?delete='.$Row; ?>" class="btn btn-block btn-success">Yes</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
    <div class="card-text">
      <h2><?php echo SpacesBeforeCapitals( $Table ); ?></h2>
<?php
  
  if($Row == false){
    echo '<form action="/'.$Schema.'/'.$Table.'/?insert" method="post">'.PHP_EOL;
  }else{
    echo '<form action="/'.$Schema.'/'.$Table.'/?update" method="post">'.PHP_EOL;
  }
  
  //go through all the columns and display a field for them
  foreach($Columns as $Column){
    
    echo PHP_EOL."<!--".PHP_EOL;
    var_dump($Column);
    echo PHP_EOL."-->".PHP_EOL;
    
    //skip any meta data about the table. we only want to look at the columns which will all have this field.
    if(!isset($Column['IsConstraint'])){continue;}
    
    if($Row != false){
      $FieldValue = $Data[$Column['COLUMN_NAME']];
    }else{
      $FieldValue = '';
    }
    
    //if this is the primary key, display it as text, and include a hidden input field of it
    if($Column['IsConstraint']['PRIMARY KEY'] == true){
      if($Data != false){
        //We don't need to show a field for primary key if we are inserting a new row
        SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue);
      }
      continue;
    }
    
    //if this is a foreign key, display it as a link to the thing it goes to.
    if($Column['IsConstraint']['FOREIGN KEY'] == true){

      if(HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'].'_Edit')){
        
        //Editable foreign Key
        SchemaRouter_RowColumns_Fields_BodyCallback_EditableForeignKey($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue,$Schema,$Table);
        
      }elseif( HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME']) ){
        
        //Read only foreign key
        SchemaRouter_RowColumns_Fields_BodyCallback_ForeignKey($Schema, $Column,$FieldValue);
        
      }
      
      continue;
    }else{Event('Column is not a foreign Key');}
    
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
      SchemaRouter_RowColumns_Fields_BodyCallback_EditableText($Column['COLUMN_NAME'], $Column['COLUMN_NAME'], $FieldValue,$Schema,$Table);
      
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
            <input class="form-control btn btn-block btn-success AstriaToggleEditableInputs" type="submit" value="Save Changes">
          </div>
        </div>
      

      </form>
    
    </div>
  </div>
</div>

  <?php
  
  if( 
    count($Referencees)>0 && 
    $Data != false
  ){
    //display two columns, one for this table, and one for things that have foreign keys referencing it
    echo '</div>'.PHP_EOL.'<div class="col-xs-12 col-lg-6">'.PHP_EOL;
    
    foreach($Referencees as $Table => $Referencee){
      ?>

      <div class="card">
        <div class="card-block">
          <div class="card-text">
            <h3>
              <span style="float: right;"><a class="text-muted" href="/<?php echo $Schema; ?>/<?php echo $Table; ?>/?insert&<?php echo $PrimaryKey; ?>=<?php echo $Row; ?>"><i class="material-icons">add</i></a></span>
              <?php echo rtrim($Referencee['TABLE_NAME'],'s').'s'; ?>
            </h3>
              
            <?php
              
              $SQL ="SELECT CONCAT('<a href=\"/".$Schema."/".$Table."/',".Sanitize($ASTRIA['Session']['Schema'][$Schema][$Table]['PRIMARY KEY']).",'\">',`".Sanitize($ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'])."`,'</a>') as 'Connections To ".QualifiedPlural( SpacesBeforeCapitals( $Table ) )."'".PHP_EOL;
              $SQL.="FROM `".$Table."`".PHP_EOL;
              $SQL.="WHERE `".Sanitize($Referencee['REFERENCED_COLUMN_NAME'])."` = '".intval($Row)."';";
              $Links = Query( $SQL,$Schema );
              if(count($Links)==0){
                echo '<p><b>No Linked '.QualifiedPlural( SpacesBeforeCapitals( $Table ) ).' Found</b></p>';
              }else{
                foreach($Links as $LinkRow){
                  echo '<p>';
                  foreach($LinkRow as $Link){
                    echo $Link;
                  }
                  echo '</p>';
                }
              }
              
            ?>
          </div>
        </div>
      </div>

      <?php
      

      //echo '<p style="text-align: right;"><a class="text-muted" href="/'.$Schema.'/'.$Table.'/?insert&'.$PrimaryKey.'='.$Row.'">Insert New '.SpacesBeforeCapitals( $Table ).'</a></p><br>';
    }
    
  }
  ?>

</div><!--end the main column if there is only one, or the second column if there are two-->

<?php
  
}


function SchemaRouter_RowColumns_Fields_BodyCallback_ReadOnlyWithHidden($Label, $Name, $Value = ''){
  $AdditionalClasses = '';
  if(
    $Label == 'TimeInserted' ||
    $Label == 'UserInserted' ||
    $Label == 'TimeUpdated' ||
    $Label == 'UserUpdated'
  ){
    $AdditionalClasses = ' tableMeta';
  }
  ?>

        <div class="form-group row<?php echo $AdditionalClasses; ?>">
          <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-4 col-form-label"><?php echo $Label; ?>:</label>
          <div class="col-xs-12 col-lg-8">
            <input class="form-control" type="hidden" value="<?php echo htmlentities($Value); ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
            <label class="col-form-label"><?php echo $Value; ?></label>
          </div>
        </div>

  <?php
}

function SchemaRouter_RowColumns_Fields_BodyCallback_ForeignKey($Schema,$Column,$Value){
  global $ASTRIA;
  foreach($Column['Constraints'] as $Constraint){
    if($Constraint['CONSTRAINT_TYPE'] == 'FOREIGN KEY'){
      $ForeignKeyConstraint = $Constraint;
    }
  }
  
  $PrimaryKey     = $ASTRIA['Session']['Schema'][$Schema][$ForeignKeyConstraint['REFERENCED_TABLE_NAME']]['PRIMARY KEY'];
  $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$ForeignKeyConstraint['REFERENCED_TABLE_NAME']]['FirstTextField'];
  $SQL = "SELECT `".Sanitize($FirstTextField)."` FROM `".Sanitize($ForeignKeyConstraint['REFERENCED_TABLE_NAME'])."` WHERE `".Sanitize($PrimaryKey)."` = ".intval($Value);
  $Description = Query($SQL,$Schema);
  //TODO these errors should be more elegant
  if(!(isset($Description[0]))){echo '<p>Unable to locate reference field for object.</p>';pd($SQL);pd($Description);}
  if(!(isset($Description[0][ Sanitize($FirstTextField) ]))){echo 'Unable to locate reference field for object.';pd($SQL);pd($Description);}
  $Description = $Description[0][ Sanitize($FirstTextField) ];
  ?>

        <div class="form-group row">
          <label class="col-xs-12 col-lg-4 col-form-label"><?php echo $ForeignKeyConstraint['REFERENCED_TABLE_NAME']; ?>:</label>
          <div class="col-xs-12 col-lg-8">
            <label class="col-form-label">
              <a href="/<?php echo $Schema.'/'.$ForeignKeyConstraint['REFERENCED_TABLE_NAME'].'/'.$Value; ?>"><?php echo $Description; ?></a>
              <?php //TODO ?>
              <a href="#" class="AstriaToggleEditableInputs"><i class="material-icons">edit</i></a>
            </label>
          </div>
        </div>

  <?php
}

function SchemaRouter_RowColumns_Fields_BodyCallback_EditableText($Label, $Name, $Value = '',$Schema,$Table){
  global $ASTRIA;
  if($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['IS_NULLABLE']=='NO'){
    $Required = true;
  }else{
    $Required = false;
  }
  ?>

        <div class="form-group row">
          <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-4 col-form-label">
            <?php 
              
              echo $Label.':';
              if($Required){
                echo '<br><b>Required</b>';
              }
              
            ?>
          </label>
          <div class="col-xs-12 col-lg-8">
            <?php
              switch($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['DATA_TYPE']){
                case 'boolean':
                case 'tinyint':
                  ?>
                  <select class="form-control AstriaToggleEditableInputs" <?php if($Required){echo 'required="true" ';} ?>value="<?php if(isset($_GET[$Name])){echo $_GET[$Name];}else{ echo $Value; } ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
                    <?php if(!$Required){ ?>
                    <option value="">Leave Blank</option>
                    <?php } ?>
                    <option value="0"<?php if($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['COLUMN_DEFAULT']==0){echo ' selected="selected"';} ?>>False<?php if($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['COLUMN_DEFAULT']==0){echo ' (Default)';} ?></option>
                    <option value="1"<?php if($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['COLUMN_DEFAULT']==1){echo ' selected="selected"';} ?>>True <?php if($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['COLUMN_DEFAULT']==1){echo ' (Default)';} ?></option>
                  </select>
                  <?php
                  break;
                case 'date':
                case 'datetime':
                  ?>
                  <input class="form-control AstriaToggleEditableInputs" type="datetime-local" <?php if($Required){echo 'required="true" ';} ?>value="<?php if(isset($_GET[$Name])){echo $_GET[$Name];}else{ echo $Value; } ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
                  <?php
                  break;
                case 'text':
                case 'longtext':
                  ?>
                  <textarea rows="8" class="form-control AstriaToggleEditableInputs" type="text" <?php if($Required){echo 'required="true" ';} ?>id="<?php echo $Name; ?>" name="<?php echo $Name; ?>"><?php if(isset($_GET[$Name])){echo $_GET[$Name];}else{echo $Value;} ?></textarea>
                  <?php
                  break;
                case 'varchar':
                case 'int':
                  ?>
                  <input class="form-control AstriaToggleEditableInputs" type="text" <?php if($Required){echo 'required="true" ';} ?>value="<?php if(isset($_GET[$Name])){echo $_GET[$Name];}else{echo $Value;} ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
                  <?php
                  break;
                default:
                  echo '<p>Data Type Input Not Implemented.</p>';
                  pd($ASTRIA['Session']['Schema'][$Schema][$Table][$Name]);
              }
            ?>
            <label class="col-form-label AstriaToggleEditableLabels">
              <?php 
                if(
                  $ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['DATA_TYPE']=='text' ||
                  $ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['DATA_TYPE']=='longtext' ||
                  $ASTRIA['Session']['Schema'][$Schema][$Table][$Name]['DATA_TYPE']=='varchar'
                ){
                  $Value = htmlentities($Value);
                  $Value = str_replace(PHP_EOL,'<br>',$Value);
                  $Value = str_replace(' ',' &nbsp;',$Value);
                }
                echo $Value; 
              ?>
            </label>
          </div>
        </div>

  <?php
  
}

function SchemaRouter_RowColumns_Fields_BodyCallback_EditableForeignKey($Label, $Name, $Value = '',$Schema,$Table){
  global $ASTRIA;
  $This = $ASTRIA['Session']['Schema'][$Schema][$Table][$Name];
  if($This['IS_NULLABLE']=='NO'){
    $Required = true;
  }else{
    $Required = false;
  }
  ?>

        <div class="form-group row">
          <label for="<?php echo $Name; ?>" class="col-xs-12 col-lg-4 col-form-label">
            <?php 
              
              echo $Label.':';
              if($Required){
                echo '<br><b>Required</b>';
              }
              
            ?>
          </label>
          <div class="col-xs-12 col-lg-8">
            
            <select class="form-control AstriaToggleEditableInputs" <?php if($Required){echo 'required="true" ';} ?>value="<?php if(isset($_GET[$Name])){echo $_GET[$Name];}else{ echo $Value; } ?>" id="<?php echo $Name; ?>" name="<?php echo $Name; ?>">
              <?php if(!$Required){ ?>
              <option value="">Leave Blank</option>
              <?php } ?>
              <?php 
                
                foreach($This['Constraints'] as $Constraint){
                  if($Constraint['CONSTRAINT_TYPE'] == 'FOREIGN KEY'){
                    $ForeignKeyConstraint = $Constraint;
                  }
                }
  
                $PrimaryKey     = $ASTRIA['Session']['Schema'][$Schema][$ForeignKeyConstraint['REFERENCED_TABLE_NAME']]['PRIMARY KEY'];
                $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$ForeignKeyConstraint['REFERENCED_TABLE_NAME']]['FirstTextField'];
                $SQL = "SELECT `".Sanitize($PrimaryKey)."`,`".Sanitize($FirstTextField)."` FROM `".Sanitize($ForeignKeyConstraint['REFERENCED_TABLE_NAME'])."`;";
                $Description = Query($SQL,$Schema);
                //TODO these errors should be more elegant
                //if(!(isset($Description[0]))){echo '<p>Unable to locate reference field for object.</p>';pd($SQL);pd($Description);}
                //if(!(isset($Description[0][ Sanitize($FirstTextField) ]))){echo 'Unable to locate reference field for object.';pd($SQL);pd($Description);}
                
                foreach($Description as $Reference){
                  //pd($Reference);
                  //echo PHP_EOL."<!-- ".$FirstTextField.": ".$Reference[$FirstTextField]." -->".PHP_EOL;
                  //echo PHP_EOL."<!-- ".$PrimaryKey.": ".$Reference[$PrimaryKey]." -->".PHP_EOL;
                  ?>
                  <option value="<?php echo $Reference[$PrimaryKey]; ?>"<?php if($Value==$Reference[$FirstTextField]){echo ' selected="selected"';} ?>>
                    <?php echo $Reference[$FirstTextField]; ?> 
                    <?php if($Value==$Reference[$FirstTextField]){echo ' (Current Value)';} ?>
                  </option>
                  <?php
                }
                
              ?>
            </select>
            <label class="col-form-label AstriaToggleEditableLabels"><?php echo $Value; ?></label>
          </div>
        </div>

  <?php
  
}
