<?php

function MySQLDescribeDatabase($Alias){
  $Tables = Query('SHOW TABLES',$Alias);
  foreach($Tables as $Key => $Value){
    pd($Value);
  }
}
