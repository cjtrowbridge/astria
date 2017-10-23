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
  echo '<h1><div style="float: right; white-space: nowrap;"><a href="./?insert" class="btn btn-outline-success">New</a> <a href="javascript:void(0);" onclick="SchemaRouterSearch();" class="btn btn-outline-success">Search</a></div>/ <a href="/'.$Schema.'/">'.$ASTRIA['databases'][$Schema]['title'].'</a> / <a href="/'.$Schema.'/'.$Table.'/">'.$Table.'</a></h1>';
  SchemaRouter_QueryCard();
  echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC LIMIT 100",$Schema));
}
