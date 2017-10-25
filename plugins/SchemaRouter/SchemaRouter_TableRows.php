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
      <a href="./?insert" class="btn btn-success">New</a> 
      <a href="javascript:void(0);" onclick="SchemaRouterSearch();" class="btn btn-success">Search</a>
    </div>
    / <a href="/<?php echo $Schema; ?>/"><?php echo $ASTRIA['databases'][$Schema]['title']; ?></a> 
    / <a href="/<?php echo $Schema; ?>/<?php echo $Table; ?>/"><?php echo $Table; ?></a>
  </h1>
  
  <?php
  SchemaRouter_QueryCard();
  
  //convert any keys to links to the thing those are keys for
  
  $SQL = "SELECT ";
  foreach($ASTRIA['Session']['Schema'][$Schema][$Table] as $Column){
    $FirstTextField = $ASTRIA['Session']['Schema'][$Schema][$Table]['FirstTextField'];
    if(
      isset($Column['COLUMN_NAME'])&&
      (!($Column['COLUMN_NAME'] == $FirstTextField))
      
    ){
      if($Column['IsConstraint']['PRIMARY KEY']){
        $SQL.="CONCAT('<a href=\"/".$Schema."/".$Table."/',`".Sanitize($Column['COLUMN_NAME'])."`,'\">',`".Sanitize($FirstTextField)."`,'</a>') as '".Sanitize($Table)."',";
      }else{
        $SQL.="`".$Column['COLUMN_NAME']."`,";
      }
    }
  }
  $SQL = rtrim($SQL,",");
  $SQL.=" FROM `".$Table."` ORDER BY 1 DESC LIMIT 100";
  pd($SQL);
  
  echo ArrTabler(Query($SQL,$Schema));
}
