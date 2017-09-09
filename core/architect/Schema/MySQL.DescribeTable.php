<?php

function MySQLDescribeTable($Table){
  global $ASTRIA;
  $DBName = $ASTRIA['databases'][$Alias]['database'];
  $Tables = Query('DESCRIBE `'.Sanitize($Table).'`',$Alias);
  
  echo '<h1>Database: "'.$Alias.'"'." '".$DBName."'.'".$Table."' </h1>';
  echo PHP_EOL."<ul>".PHP_EOL;
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo '  <li><a href="/architect/schema/'.path(2).'/table/'.$Table.'">'.$Table.'</a></li>'.PHP_EOL;
  }
  echo "</ul>".PHP_EOL;
}
