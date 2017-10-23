<?php

function SchemaRouter_AllSchemas(){
  //this will always simply be a list of all the schemas this user has permission to view
  //this could be json
  //or the contents of a dom object
  //default to a full page with template
}

function SchemaRouter_AllSchemas_DOM(){
  //this function returns a string which shows a dom ui for accessing each schema which the user has any recursive permission to view
  $AllSchemas = SchemaRouter_AllSchemas_Array();
  return '<pre>'.var_export($AllSchemas,true).'</pre>';
}

function SchemaRouter_AllSchemas_Array(){
  //this function returns an array of each schema which the user has any recursive permission to view
  global $ASTRIA;
  
  //initialize the output list
  $Schemas = array();
  
  foreach($ASTRIA['databases'] as $Alias => $Database){
    $PermissionString = 'Schema_'.$Alias.'_';
    if(HasPermissionBeginingWith($PermissionString)){
      $Schemas[$Alias]=$Database['name'];
    }
  }
  
  return $Schemas;
}
