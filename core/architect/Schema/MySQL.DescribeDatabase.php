<?php

function MySQLDescribeDatabase($Alias){
  $Tables = Query('SHOW TABLES',$Alias);
  foreach($Tables as $Table){
    $Table = array_shift($Table);
    echo $Table;
  }
}
