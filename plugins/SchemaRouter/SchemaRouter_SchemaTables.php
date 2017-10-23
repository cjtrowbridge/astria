<?php

function SchemaRouter_SchemaTables($Schema){
  //this could be an insert of a new table
  //or an update to a table's structure
  //default to returning a list of all tables in the given schema
    //this could be json
    //or the contents of a dom object
    //default to a full page with template
}

function SchemaRouter_SchemaTables_DOM_UL($Schema){
  //this function returns a string which shows a dom ul for accessing each table in this schema which the user has any recursive permission to view
  $AllSchemaTables = SchemaRouter_SchemaTables_Array($Schema);
  $R= PHP_EOL.PHP_EOL.'<ul>'.PHP_EOL;
  foreach($AllSchemaTables as $Table){
    $R.= '  <li><a href="/'.$Schema.'/'.$Table.'/">'.$Table.'</a></li>'.PHP_EOL;
  }
  $R.= PHP_EOL.'</ul>'.PHP_EOL.PHP_EOL;
  return $R;
}

function SchemaRouter_SchemaTables_Array($Schema){
  //this function returns an array of each table in this schema which the user has any recursive permission to view
  global $ASTRIA;
  
  //initialize the output list
  $R = array();
  
  $Tables = Query('SHOW TABLES',$Alias);
  
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    
    $PermissionString = 'Schema_'.$Schema.'_Table_'.$Table.'_';
    Event('Checking If User Has Any Permissions Begining with: '.$PermissionString);
    if(HasPermissionBeginingWith($PermissionString)){
      Event('Yes');
      $R[]=$Table;
    }else{
      Event('None found.');
    }
  }
  
  return $R;
}
