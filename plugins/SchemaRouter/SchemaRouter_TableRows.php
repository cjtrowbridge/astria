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
  echo '<h1><a href="/'.$SChema.'/">'.$ASTRIA['databases'][$Schema]['title'].'</a> / <a href="/'.$SChema.'/'.$Table.'/">'.$Table.'</h1>';
  echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC",$Schema));
}
