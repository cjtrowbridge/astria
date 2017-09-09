<?php

function MySQLDescribeDatabase($Alias){
  $Tables = Query('SHOW TABLES',$Alias);
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo '<p><a href="/architect/schema/'.path(2).'/'.path(3).'/'.$Table'">'.$Table.'</a></p>';
  }
}
