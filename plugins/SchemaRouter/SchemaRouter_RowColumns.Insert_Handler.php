<?php

function SchemaRouter_RowColumns_Insert_Handler($Schema, $Table){
  Event('Handling SchemaRouter Insert...');
  global $ASTRIA;
  
  $Columns = $ASTRIA['Session']['Schema'][$Schema][$Table];
  
  $InsertValues = array();
  //go through all the columns and verify permission to edit them. only columns for which the user has permission will be allowed.
  foreach($Columns as $Column){
    
    //skip any meta data about the table. we only want to look at the columns which will all have this field.
    if(!isset($Column['IsConstraint'])){continue;}
    
    //skip the primary key since this is an insert.
    if($Column['IsConstraint']['PRIMARY KEY'] == true){continue;}
    
    //TODO foreign keys
    
    //Check what we need to do with this field. Maybe editable, maybe just viewable, maybe neither.
    if(
      (!( //These columns are never editable
        $Column['COLUMN_NAME'] == 'TimeInserted' ||
        $Column['COLUMN_NAME'] == 'UserInserted' ||
        $Column['COLUMN_NAME'] == 'TimeUpdated' ||
        $Column['COLUMN_NAME'] == 'UserUpdated'
      )) &&
      HasPermission('Schema_'.$Schema.'_Table_'.$Table.'_Column_'.$Column['COLUMN_NAME'].'_Edit') &&
      isset($_POST[$Column['COLUMN_NAME']])
    ){
      
      switch($Column['DATA_TYPE']){
        //TODO add handlers for the other data types or for validating and formatting things properly
        default:
          $InsertValues[$Column['COLUMN_NAME']] = $_POST[$Column['COLUMN_NAME']];
          break;
      }
      
    }
  }
    
  $ColumnsList = '';
  $ValuesList = '';

  foreach($InsertValues as $Key => $Value){
    $ColumnsList .= "`".Sanitize($Key)."`,";
    $ValuesList  .= "'".Sanitize($Value)."',";
  }

  $ColumnsList = rtrim($ColumnsList,',');
  $ValuesList  = rtrim($ValuesList,',');


  $SQL = "INSERT INTO `".Sanitize($Table)."` ".PHP_EOL;
  $SQL.= "(".PHP_EOL;
  $SQL.= "  ".$ColumnsList.",`UserInserted`,`TimeInserted`".PHP_EOL;
  $SQL.= ") VALUES (".PHP_EOL;
  $SQL.= "  ".$ValuesList.",'".$ASTRIA['Session']['User']['UserID']."',NOW()".PHP_EOL;
  $SQL.= ")".PHP_EOL;
  pd($SQL);
  Query($SQL,$Schema);
  $ID = Query_LastInsertID($Schema);
  
  global $SchemaRouterLastInsert;
  $SchemaRouterLastInsert = array(
    'Table' => Sanitize($Table),
    'ID' => $ID
  );
  Event('SchemaRouter Finished Insert');
  
  header('Location: /'.$Schema.'/'.$Table.'/'.$ID);
  exit;
}
