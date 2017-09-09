<?php

function MySQLDescribeTable($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  $Description = Query('DESCRIBE `'.Sanitize($Table).'`',$Alias);
  
  echo '<h1>Database: '." '".$DBName."'.'".$Table."' </h1>";
  echo ArrTabler($Description);
  
}
