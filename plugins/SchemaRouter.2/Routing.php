<?php

function SchemaRouter_Routing(){

  //Get Route
  $Route = GetSchemaRoute()
  
  switch($Route['RouteType']){
    case 'allschemas':
      SchemaRouter_AllSchemas();
      break;
    case 'schema':
      SchemaRouter_SchemaTables($Route['Schema']);
      break;
    case 'table':
      SchemaRouter_TableRows($Route['Schema'],$Route['Table']);
      break;
    case 'row':
      SchemaRouter_RowFields($Route['Schema'],$Route['Table'],$Route['Row']);
      break;
  }
  
}

function SchemaRouter_AllSchemas(){
  //this will always simply be a list of all the schemas this user has permission to view
  //this could be json
  //or the contents of a dom object
  //default to a full page with template
}

function SchemaRouter_SchemaTables($Schema){
  //this could be an insert of a new table
  //or an update to a table's structure
  //default to returning a list of all tables in the given schema
    //this could be json
    //or the contents of a dom object
    //default to a full page with template
}

function SchemaRouter_TableRows($Schema, $Table){
  //this could be an insert of a new row
  //deafult to returning a list of rows in the table
    //this could be json
    //or the contents of a dom object
    //default to a full page with template
}

function SchemaRouter_RowFields($Schema, $Table, $Row){
  //this could be an update to an existing row
  //or a delete of a row
  //default to returning the row
    //this could be json
    //or the contents of a dom object
}

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
