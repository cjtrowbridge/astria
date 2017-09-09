<?php

function MySQLDescribeDatabase($Alias){
  global $ASTRIA;
  $Name = $ASTRIA['databases'][$Alias]['database'];
  $Type = $ASTRIA['databases'][$Alias]['type'];
  $Tables = Query('SHOW TABLES',$Alias);
  
  echo '<h1>Database: "'.$Alias.'" '.$Type.'://'.$Name.'/ </h1>';
  echo PHP_EOL."<ul>".PHP_EOL;
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo '  <li><a href="/architect/schema/'.path(2).'/'.path(3).'/table/'.$Table.'">'.$Table.'</a></li>'.PHP_EOL;
  }
  echo "</ul>".PHP_EOL;
}
