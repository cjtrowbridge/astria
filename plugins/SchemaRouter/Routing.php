<?php

// example permission 
//   Schema_firebridgecrm_Table_Customer_Column_BillingZIP

Hook('Challenge Session','SchemaRouter_SchemaDescription(true);');

Hook('User Is Logged In','SchemaRouter_SchemaDescription();');
//Hook('Done Reloading User Permissions Into Session','SchemaRouter_SchemaDescription();');

Hook('User Is Logged In - Before Presentation','SchemaRouter_Routing();');
Hook('User Is Logged In - Homepage Content','SchemaRouter_Default_Homepage();');


function SchemaRouter_Default_Homepage(){
  echo '<h1>Databases</h1>'.PHP_EOL.SchemaRouter_AllSchemas_DOM_UL();
}

function SchemaRouter_Routing(){

  //include DOM functions so views can be included in outside pages
  include_once('SchemaRouter_AllSchemas.php');
  include_once('SchemaRouter_SchemaTables.php');
  include_once('SchemaRouter_TableRows.php');
  include_once('SchemaRouter_RowColumns.php');
  
  //Get Route
  include_once('GetSchemaRoute.php');
  $Route = GetSchemaRoute();

  //call the appropriate router for the route's hierarchical level
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
      SchemaRouter_RowColumns($Route['Schema'],$Route['Table'],$Route['Row']);
      break;
  }
  
}


function SchemaRouter_QueryCard(){
 ?>

<div id="SchemaRouterQueryCard" style="display: none;"><br>
  <form class="form" method="get" action="">
    <p><input type="text" class="form-control" name="search" id="schemaSearch" placeholder="Search"></p>
  </form>
</div>
<script>
  function SchemaRouterSearch(){
    $('#SchemaRouterQueryCard').slideToggle('fast',function(){
      $('#schemaSearch').focus();
    });
  }
</script>

  <?php
  
}

function SchemaRouterGet_Referencees($Schema, $Table){
  
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $ConstraintSQL = "
    SELECT COLUMN_NAME, KEY_COLUMN_USAGE.TABLE_NAME, CONSTRAINT_TYPE, REFERENCED_COLUMN_NAME, REFERENCED_TABLE_NAME
    FROM information_schema.KEY_COLUMN_USAGE 
    LEFT JOIN information_schema.TABLE_CONSTRAINTS ON
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA    = information_schema.KEY_COLUMN_USAGE.TABLE_SCHEMA AND
      information_schema.TABLE_CONSTRAINTS.TABLE_NAME      = information_schema.KEY_COLUMN_USAGE.TABLE_NAME AND
      information_schema.TABLE_CONSTRAINTS.CONSTRAINT_NAME = information_schema.KEY_COLUMN_USAGE.CONSTRAINT_NAME
    WHERE 
      information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA          = '".Sanitize($DatabaseName)."' AND
      information_schema.KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME = '".Sanitize($Table)."'
  ";
  
  $Referencees = Query($ConstraintSQL,$Schema);
  $Output = array();
  
  foreach($Referencees as $Referencee){
    $Output[ $Referencee['TABLE_NAME'] ] = $Referencee;
  }
  
  return $Output;
}

function SchemaRouterGet_Constraints($Schema, $Table){
  
  global $ASTRIA;
  //Dereference schema
  $DatabaseName = $ASTRIA['databases'][$Schema]['database'];
  
  $ColumnSQL = "SELECT TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,DATA_TYPE,IS_NULLABLE,COLUMN_DEFAULT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".Sanitize($DatabaseName)."' AND TABLE_NAME = '".Sanitize($Table)."'";
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
  
  foreach($Data as $Index => $Column){
    
    $Data[ $Column['COLUMN_NAME'] ] = $Column;
    
    //initialize an array to hold this column's constraints
    $Data[ $Column['COLUMN_NAME'] ]['Constraints'] = array();
    $Data[ $Column['COLUMN_NAME'] ]['IsConstraint'] = array(
      'UNIQUE'      => false,
      'PRIMARY KEY' => false,
      'FOREIGN KEY' => false,
      'CHECK'       => false
    );
    
    //look through all the constraints and put them in the constraints array for each column
    foreach($Constraints as $Constraint){
      if($Column['COLUMN_NAME'] == $Constraint['COLUMN_NAME']){
        $Data[ $Column['COLUMN_NAME'] ]['Constraints'][] = $Constraint;
        $Data[ $Column['COLUMN_NAME'] ]['IsConstraint'][ $Constraint['CONSTRAINT_TYPE'] ] = true;
      }
    }
    unset($Data[$Index]);
  }
  
  return $Data;
}


function SchemaRouter_SchemaDescription($ForceReload = false){
  global $ASTRIA;
  if(
    isset($ASTRIA['Session']['Schema']) &&
    ($ForceReload == false)
  ){
    Event('Schema Description Already Loaded.');
    return $ASTRIA['Session']['Schema'];
  }
  
  $Session = null;
  if(isset(
    $_COOKIE[ strtolower(md5($ASTRIA['app']['appURL'])) ]
                    )){ $Session = $_COOKIE[ strtolower(md5($ASTRIA['app']['appURL']))]; }
  Event('Loading Schema Description Into Session: '.$Session);
  
  include_once('SchemaRouter_AllSchemas.php');
  include_once('SchemaRouter_SchemaTables.php');
  include_once('SchemaRouter_TableRows.php');
  include_once('SchemaRouter_RowColumns.php');
  
  //If this has not already happened during this session, do it now and cache it into the session
  //We can take for granted that permissions are already done, as this function is hooked immediately after that.
  
  $InitialMemoryAllocated = memory_get_usage();
  
  //Initialize the return variable
  $SchemaDescription = array();
  
  //get list of tables user has permissions for
  $AllSchemas = SchemaRouter_AllSchemas_Array();
  foreach($AllSchemas as $Alias => $Title){
    
    //add a list of tables the user has any permissions for
    $SchemaDescription[$Alias] = SchemaRouter_SchemaTables_Array($Alias);
    foreach($SchemaDescription[$Alias] as $Index  => $Table){
      //if(!(isset($Column['DATA_TYPE']))){
        //continue;
      //}
      unset($SchemaDescription[$Alias][$Index]);
      $SchemaDescription[$Alias][$Table] = SchemaRouterGet_Constraints($Alias, $Table);
      $SchemaDescription[$Alias][$Table]['FirstTextField'] = '';
      $SchemaDescription[$Alias][$Table]['PRIMARY KEY'] = '';
      
      foreach($SchemaDescription[$Alias][$Table] as $Column){
        if(
          $SchemaDescription[$Alias][$Table]['FirstTextField'] == '' &&
          isset($Column['DATA_TYPE'])&&
          (
            $Column['DATA_TYPE'] == 'varchar'||
            $Column['DATA_TYPE'] == 'longtext'||
            $Column['DATA_TYPE'] == 'text'||
            $Column['DATA_TYPE'] == 'date'||
            $Column['DATA_TYPE'] == 'datetime'||
            $Column['DATA_TYPE'] == 'timestamp'
          )
        ){
          $SchemaDescription[$Alias][$Table]['FirstTextField'] = $Column['COLUMN_NAME'];
        }
        if(
          $SchemaDescription[$Alias][$Table]['PRIMARY KEY'] == '' &&
          isset($Column['IsConstraint'])&&
          $Column['IsConstraint']['PRIMARY KEY'] == true
        ){
          $SchemaDescription[$Alias][$Table]['PRIMARY KEY'] = $Column['COLUMN_NAME'];
          $SchemaDescription[$Alias][$Table]['Referencees'] = SchemaRouterGet_Referencees($Alias, $Table);
        }
      }
    }
  }
  
  //save this into the session and then return it.
  $MemoryAllocated = memory_get_usage() - $InitialMemoryAllocated;
  $ASTRIA['Session']['Schema'] = $SchemaDescription;                                   
  $Session = null;if(isset($_COOKIE[ strtolower(md5($ASTRIA['app']['appURL'])) ])){ $Session = $_COOKIE[ strtolower(md5($ASTRIA['app']['appURL']))]; }
  Event('Done Loading Schema Description Into Session: '.$Session.'. Space Allocated: '.($MemoryAllocated/1024).'kb');
  
  AstriaSessionSave();
  return $SchemaDescription;
}
