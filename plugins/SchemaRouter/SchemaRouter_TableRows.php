<?php

function SchemaRouter_TableRows($Schema, $Table){
  //TODO this could be an insert of a new row
  //TODO deafult to returning a list of rows in the table
    //TODO this could be json
    //TODO or the contents of a dom object
    //TODO default to a full page with template
    global $ASTRIA;
    TemplateBootstrap4($Table.' - '.$ASTRIA['databases'][$Schema]['title'],'SchemaRouter_TableRows_DOM_Page("'.$Schema.'","'.$Table.'");');
}

function SchemaRouter_TableRows_DOM_Page($Schema,$Table){
  $Table = Sanitize($Table);
  global $ASTRIA;
  ?>

  <h1>
    <div style="float: right; white-space: nowrap;">
      
      <?php if($ASTRIA['Session']['User']['IsAstriaAdmin']){ /* If User is an admin; */ ?>
      <a href="./?show_query" class="btn btn-success">Show Query</a> 
      <?php } ?>
      
      <a href="./?insert" class="btn btn-success">New</a> 
      <a href="javascript:void(0);" onclick="SchemaRouterSearch();" class="btn btn-success">Search</a>
    </div>
    / <a href="/<?php echo $Schema; ?>/"><?php echo $ASTRIA['databases'][$Schema]['title']; ?></a> 
    / <a href="/<?php echo $Schema; ?>/<?php echo $Table; ?>/"><?php echo $Table; ?></a>
  </h1>
  
  <?php
  
  //display a standard search form on each table page
  SchemaRouter_QueryCard();
  
  
  //query the table, while enriching the data with relevant content
  $SQL = " SELECT ".PHP_EOL;
  $AddressDone = false;
  foreach($ASTRIA['Session']['Schema'][$Schema][$Table] as $Column){
    $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
    
    
    //Skip meta data. We are only interested in column data
    if(!isset($Column['COLUMN_NAME'])){
      continue;
    }
    
    
    //Skip These Columns by Default
    if(
      ($Column['COLUMN_NAME'] == $FirstTextField)||
      ($Column['COLUMN_NAME'] == 'UserInserted')||
      ($Column['COLUMN_NAME'] == 'TimeInserted')||
      ($Column['COLUMN_NAME'] == 'UserUpdated')||
      ($Column['COLUMN_NAME'] == 'TimeUpdated')
    ){
      continue;
    }
    
    
    //Any address related fields will be combined into a single address field
    if(
      ($Column['COLUMN_NAME'] == 'BillingAddress')||
      ($Column['COLUMN_NAME'] == 'BillingAddress1')||
      ($Column['COLUMN_NAME'] == 'BillingAddress2')||
      ($Column['COLUMN_NAME'] == 'BillingAddress3')||
      ($Column['COLUMN_NAME'] == 'BillingZIP')||
      ($Column['COLUMN_NAME'] == 'BillingZIPCode')||
      ($Column['COLUMN_NAME'] == 'BillingPostalCode')||
      ($Column['COLUMN_NAME'] == 'BillingState')||
      ($Column['COLUMN_NAME'] == 'BillingCountry')||
      ($Column['COLUMN_NAME'] == 'Address')||
      ($Column['COLUMN_NAME'] == 'Address1')||
      ($Column['COLUMN_NAME'] == 'Address2')||
      ($Column['COLUMN_NAME'] == 'Address3')||
      ($Column['COLUMN_NAME'] == 'ZIP')||
      ($Column['COLUMN_NAME'] == 'ZIPCode')||
      ($Column['COLUMN_NAME'] == 'PostalCode')||
      ($Column['COLUMN_NAME'] == 'State')||
      ($Column['COLUMN_NAME'] == 'Country')||
      ($Column['COLUMN_NAME'] == 'Latitude')||
      ($Column['COLUMN_NAME'] == 'Longitude')
    ){
      if($AddressDone==false){
        $AddressDone = true;
        $SQL.="  CONCAT('<a href=\"https://www.google.com/maps/search/',".GetSmartAddressFieldConcat($Schema,$Table).",'\">Map: ','".GetSmartAddressFieldConcat($Schema,$Table)."','</a>') as 'Address',".PHP_EOL;
      }
      continue;
    }
    
    
    //If the column is a primary key, make it a link to itself and combine the reference field with the key field
    if($Column['IsConstraint']['PRIMARY KEY']){
      $SQL.="  CONCAT('<a href=\"/".$Schema."/".$Table."/',`".Sanitize($Column['COLUMN_NAME'])."`,'\">',`".Sanitize($FirstTextField)."`,'</a>') as '".Sanitize($Table)."',".PHP_EOL;
      continue;
    }
    
    
    //If the column is a foreign key, make it be a link to that thing
    if($Column['IsConstraint']['FOREIGN KEY']){
      foreach($Column['Constraints'] as $Constraint){
        if(isset($Constraint['REFERENCED_TABLE_NAME'])){
          $ForeignTable = $Constraint['REFERENCED_TABLE_NAME'];
        }
      }
      $ForeignObjectName = $ASTRIA['Session']['Schema'][$Schema][$ForeignTable]['FirstTextField'];

      $SQL.="  CONCAT('<a href=\"/".$Schema."/".Sanitize($ForeignTable)."/',`".Sanitize($Column['COLUMN_NAME'])."`,'\">',(SELECT `".Sanitize($ForeignObjectName)."` FROM `".Sanitize($ForeignTable)."` WHERE `".Sanitize($ForeignTable)."`.`".Sanitize($Column['COLUMN_NAME'])."` = `".$Table."`.`".Sanitize($Column['COLUMN_NAME'])."`),'</a>') as '".Sanitize($ForeignObjectName)."',".PHP_EOL;
      continue;
    }
    
    
    //If the column is an email, make it a link to that email
    if(strpos(strtolower($Column['COLUMN_NAME']),'email') !== false){
      $SQL.="  CONCAT('<a href=\"mailto:',`".Sanitize($Column['COLUMN_NAME'])."`,'\">',`".Sanitize($Column['COLUMN_NAME'])."`,'</a>') as '".Sanitize($Column['COLUMN_NAME'])."',".PHP_EOL;
      continue;
    }
    
    
    //If the column is a phone number, make it a link to that phone number
    if(
      strpos(strtolower($Column['COLUMN_NAME']),'phone') !== false ||
      strpos(strtolower($Column['COLUMN_NAME']),'fax') !== false
    ){
      //TODO format the number in the output to look prettier
      $SQL.="  CONCAT('<a href=\"tel:',`".Sanitize($Column['COLUMN_NAME'])."`,'\">',`".Sanitize($Column['COLUMN_NAME'])."`,'</a>') as '".Sanitize($Column['COLUMN_NAME'])."',".PHP_EOL;
      continue;
    }
    
    
    //If it is just a regular column, display the contents normally
    $SQL.="  `".$Column['COLUMN_NAME']."`,".PHP_EOL;

  }
  $SQL = rtrim($SQL,",\n");
  $SQL.=PHP_EOL." FROM `".$Table."` ".PHP_EOL." ORDER BY 1 DESC LIMIT 100";
  
  MaybeShowQuery($SQL);
  
  echo ArrTabler(Query($SQL,$Schema));
}


function MaybeShowQuery($SQL){
  if(isset($_GET['show_query'])){
    ?>
    
    <div class="card">
      <div class="card-block">
        <div class="card-text">
          <h4>Query</h4>
          <pre><?php echo htmlentities($SQL); ?></pre>
        </div>
      </div>
    </div>

    <?php
  }
}


function GetSmartAddressFieldConcat($Schema,$Table){
  global $ASTRIA;
  $SQL = '';
  foreach($ASTRIA['Session']['Schema'][$Schema][$Table] as $Column){
    
    if(isset($Column['COLUMN_NAME'])){
      if(
        ($Column['COLUMN_NAME'] == 'BillingAddress')||
        ($Column['COLUMN_NAME'] == 'BillingAddress1')||
        ($Column['COLUMN_NAME'] == 'BillingAddress2')||
        ($Column['COLUMN_NAME'] == 'BillingAddress3')||
        ($Column['COLUMN_NAME'] == 'BillingZIP')||
        ($Column['COLUMN_NAME'] == 'BillingZIPCode')||
        ($Column['COLUMN_NAME'] == 'BillingPostalCode')||
        ($Column['COLUMN_NAME'] == 'BillingState')||
        ($Column['COLUMN_NAME'] == 'BillingCountry')||
        ($Column['COLUMN_NAME'] == 'Address')||
        ($Column['COLUMN_NAME'] == 'Address1')||
        ($Column['COLUMN_NAME'] == 'Address2')||
        ($Column['COLUMN_NAME'] == 'Address3')||
        ($Column['COLUMN_NAME'] == 'ZIP')||
        ($Column['COLUMN_NAME'] == 'ZIPCode')||
        ($Column['COLUMN_NAME'] == 'PostalCode')||
        ($Column['COLUMN_NAME'] == 'State')||
        ($Column['COLUMN_NAME'] == 'Country')||
        ($Column['COLUMN_NAME'] == 'Latitude')||
        ($Column['COLUMN_NAME'] == 'Longitude')
      ){
        $SQL.="`".$Column['COLUMN_NAME']."`,' ',";
      }
    }
    
  }
  $SQL = trim(rtrim(trim($SQL),","));
  return $SQL;
}
