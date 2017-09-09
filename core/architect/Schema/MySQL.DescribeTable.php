<?php

function MySQLDescribeTable($Alias,$Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  $Description = Query('DESCRIBE `'.Sanitize($Table).'`',$Alias);
  
  echo '<h1>Database: '." '".$DBName."'.'".$Table."' </h1>";
  echo '<h2>Description</h2>';
  echo ArrTabler($Description);
  
  echo '<h2>Data</h2>';
  echo ArrTabler(Query("SELECT * FROM `".$Table."` ORDER BY 1 DESC"));
  
}
