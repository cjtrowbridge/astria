<?php

function SchemaRouter_TableRows($Schema, $Table){
  //this could be an insert of a new row
  //deafult to returning a list of rows in the table
    //this could be json
    //or the contents of a dom object
    //default to a full page with template
    global $ASTRIA;
    TemplateBootstrap4($Table.' - '.$ASTRIA['databases'][$Schema]['title'],'SchemaRouter_TableRows_DOM_Page("'.$Schema.'","'.$Table.'");');
}

function SchemaRouter_TableRows_DOM_Page($Schema,$Table){
  $Table = Sanitize($Table);
  global $ASTRIA;
  echo '<h1><div style="float: right; white-space: nowrap;"><a href="javascript:void(0);" onclick="SchemaRouterSearch();"><i class="material-icons">search</i></a></div>/ <a href="/'.$Schema.'/">'.$ASTRIA['databases'][$Schema]['title'].'</a> / <a href="/'.$Schema.'/'.$Table.'/">'.$Table.'</a></h1>';
  SchemaRouter_QueryCard();
  echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC LIMIT 100",$Schema));
}
