<?php

// use this for recursive permissions checks for children
// https://stackoverflow.com/questions/17199482/search-array-keys-with-wildcard


function SchemaRouter_Routing(){

  //Get Route
  include_once('GetSchemaRoute.php');
  $Route = GetSchemaRoute();

  //call the appropriate router for the route's hierarchical level
  switch($Route['RouteType']){
    case 'allschemas':
      include_once('SchemaRouter_AllSchemas.php');
      SchemaRouter_AllSchemas();
      break;
    case 'schema':
      include_once('SchemaRouter_SchemaTables.php');
      SchemaRouter_SchemaTables($Route['Schema']);
      break;
    case 'table':
      include_once('SchemaRouter_TableRows.php');
      SchemaRouter_TableRows($Route['Schema'],$Route['Table']);
      break;
    case 'row':
      include_once('SchemaRouter_RowFields.php');
      SchemaRouter_RowFields($Route['Schema'],$Route['Table'],$Route['Row']);
      break;
  }
  
}
