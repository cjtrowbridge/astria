<?php

function GetSchemaRoute(){
  $Schema = path(0,false);
  $Table  = path(1,false);
  $Row    = path(2,false);
  
  if(!( $Row === false )){
    $RouteType = 'row';
  }else{
    if(!( $Table === false )){
      $RouteType = 'table';
    }else{
      if(!( $Schema === false )){
        $RouteType = 'schema';
      }else{
        $RouteType = 'allschemas';
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
