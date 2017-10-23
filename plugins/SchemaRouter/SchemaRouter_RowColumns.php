<?php

function SchemaRouter_RowColumns($Schema, $Table, $Row){
  //TODO this could be an update to an existing row
  //TODO or a delete of a row
  //TODO default to returning the row
    //TODO this could be json
    //TODO or the contents of a dom object
    pd(SchemaRouter_RowColumns_Fields($Schema, $Table));
    exit;
}

function SchemaRouter_RowColumns_Fields($Schema, $Table){
  
  global $ASTRIA;
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $ColumnSQL = "SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND TABLE_NAME = '".Sanitize($Table)."'";
  $ConstraintSQL = "
  
    SELECT COLUMN_NAME, CONSTRAINT_TYPE, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
    FROM information_schema.KEY_COLUMN_USAGE 
    LEFT JOIN information_schema.TABLE_CONSTRAINTS ON
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA    = information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA AND
      information_schema.TABLE_CONSTRAINTS.TABLE_NAME      = information_schema.KEY_COLUMN_USAGE.TABLE_NAME AND
      information_schema.TABLE_CONSTRAINTS.CONSTRAINT_NAME = information_schema.KEY_COLUMN_USAGE.CONSTRAINT_NAME
    WHERE 
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND
      information_schema.TABLE_CONSTRAINTS.TABLE_NAME   = '".Sanitize($Table)."'
  ";
  
  $Data        = Query($ColumnSQL,$Schema);
  $Constraints = Query($ConstraintSQL,$Schema);
  
  foreach($Data as &$Column){
    
    //initialize an array to hold this column's constraints
    $Column['Constraints']=array();
    
    //look through all the constraints and put them in the constraints array for each column
    foreach($Constraints as $Constraint){
      if($Column['COLUMN_NAME'] == $Constraint['COLUMN_NAME']){
        $Column['Constraints'][ $Constraint['CONSTRAINT_TYPE'] ] = $Constraint;
      }
    }
  }
  
  return $Data;
}
