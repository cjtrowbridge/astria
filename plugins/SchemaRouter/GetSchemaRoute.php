<?php

function GetSchemaRoute($Schema = false, $Table = false, $Row = false){
  
  //TODO set global variables for these so that this function can be called to set them, and then later called to recall the values passed into it rather than parsing new values from the path. This way, the default behavior can be overridden.
  
  if($Schema == false){
    $Schema = path(0,false);
  }
  if($Table == false){
    $Table  = path(1,false);
  }
  if($Row == false){
    $Row    = path(2,false);
  }
  
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][$Schema]))){
    $RouteType = false;
    $Schema    = false;
    $Table     = false;
    $Row       = false;
  }else{
    if(!( $Row === false )){
      $RouteType = 'row';
    }else{
      if(!( $Table === false )){
        
        //check if we are doing an insert/update, in which case this is not a table route but a row route
        if(
          isset($_GET['insert']) || 
          isset($_GET['update']) || 
          isset($_GET['delete'])
        ){
          $RouteType = 'row';
        }else{
          $RouteType = 'table';
        }
        
      }else{
        if(!( $Schema === false )){
          $RouteType = 'schema';
        }else{
          $RouteType = 'allschemas';
        }
      }
    }
  }
  return array(
    'Schema'    => $Schema,
    'Table'     => $Table,
    'Row'       => $Row,
    'RouteType' => $RouteType
  );
}
