<?php

// example permission 
//   Schema_firebridgecrm_Table_Customer_Column_BillingZIP

Hook('User Is Logged In - Before Presentation','SchemaRouter_Routing();');

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

Hook('User Is Logged In - Homepage Content','SchemaRouter_Default_Homepage();');

function SchemaRouter_Default_Homepage(){
  echo '<h1>Databases</h1>'.PHP_EOL.SchemaRouter_AllSchemas_DOM_UL();
}

function SchemaRouter_QueryCard(){
 ?>

<div id="SchemaRouterQueryCard" style="display: none;"><br>
  <form class="form" method="get" action="">
    <p><input type="text" class="form-control" name="query" id="schemaQuery" placeholder="Search"></p>
  </form>
</div>
<script>
  function SchemaRouterSearch(){
    $('#SchemaRouterQueryCard').slideToggle('fast',function(){
      $('#schemaQuery').focus();
    });
  }
</script>

  <?php
  
}
