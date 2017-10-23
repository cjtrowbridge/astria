<?php

function SchemaRouter_AllSchemas(){
  //this will always simply be a list of all the schemas this user has permission to view
  //this could be json
  //or the contents of a dom object
  //default to a full page with template
}

function SchemaRouter_AllSchemas_DOM_UL(){
  //this function returns a string which shows a dom ui for accessing each schema which the user has any recursive permission to view
  $AllSchemas = SchemaRouter_AllSchemas_Array();
  $R= PHP_EOL.PHP_EOL.'<ul>'.PHP_EOL;
  foreach($AllSchemas as $Alias => $Database){
    $R.= '  <li><a href="/'.$Alias.'/">'.$Database.'</a></li>'.PHP_EOL;
    $R.=SchemaRouter_SchemaTables_DOM_UL($Alias);
  }
  if(count($AllSchemas)==0){
    $R.= '  <li>You do not have permission to access any databases.</li>'.PHP_EOL; //TODO make this prettier
  }
  $R.= PHP_EOL.'</ul>'.PHP_EOL.PHP_EOL;
  return $R;
}

function SchemaRouter_AllSchemas_Array(){
  //this function returns an array of each schema which the user has any recursive permission to view
  global $ASTRIA;
  
  //initialize the output list
  $Schemas = array();
  
  foreach($ASTRIA['databases'] as $Alias => $Database){
    $PermissionString = 'Schema_'.$Alias.'_';
    Event('Checking If User Has Any Permissions Begining with: '.$PermissionString);
    if(HasPermissionBeginingWith($PermissionString)){
      Event('Yes');
      $Schemas[$Alias]=$Database['title'];
    }else{
      Event('None found.');
    }
  }
  
  return $Schemas;
}
