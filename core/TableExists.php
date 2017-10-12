<?php

function TableExists($Table,$Database = 'astria'){
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][$Database]))){
    die('Invalid Database');
  }
  $DBName = $ASTRIA['databases'][$Database]['database'];
  $Table = Sanitize($Table);
  $SQL="SELECT count(*) as 'Found' FROM information_schema.tables WHERE table_schema = '$DBName' AND table_name = '".$Table."';";
  Event($SQL);
  $TableExists = Query($SQL);
  pd($TableExists);
  
  if($TableExists[0]['Found']>0){
    return false;
  }else{
    return true;
  }
}
