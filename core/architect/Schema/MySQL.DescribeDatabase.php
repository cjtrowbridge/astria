<?php

function MySQLDescribeDatabase($Alias){
  $Tables = Query('SHOW TABLES',$Alias);
  
  echo PHP_EOL."<ol>".PHP_EOL;
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo '  <li><a href="/architect/schema/'.path(2).'/'.path(3).'/'.$Table.'">'.$Table.'</a></li>'.PHP_EOL;
  }
  echo "</ol>".PHP_EOL;
}
