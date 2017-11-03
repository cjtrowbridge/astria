<?php

function SchemaRouter_RowColumns($Schema, $Table, $Row){
  //TODO this could be an update to an existing row
  //TODO or a delete of a row
  //TODO default to returning the row
    //TODO this could be json
    //TODO or the contents of a dom object
    
    //TODO make the title be more relevant 
    TemplateBootstrap4($Table.' '.$Row,'SchemaRouter_RowColumns_Fields_BodyCallback("'.$Schema.'", "'.$Table.'", "'.$Row.'")');
    exit;
}

function SchemaRouter_RowColumns_Fields_BodyCallback($Schema, $Table, $Row){
  
  global $ASTRIA;
  $Columns = $ASTRIA['Session']['Schema'][$Schema][$Table];
  pd($Columns);
  exit;
  
  
  foreach($Columns as $Column){
    
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
