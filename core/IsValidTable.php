<?php

function IsValidTable($TestTable,$Alias){
  global $ASTRIA;
  $IsTable = false;
  
  switch($ASTRIA['databases'][$Alias]['type']){

    case 'mysql':
      $Tables = Query('SHOW TABLES',$Alias);
      foreach($Tables as $ThisTable){
        $ThisTable = array_shift($ThisTable);
        if($TestTable == $ThisTable){
          $IsTable = true;
        }
      }
      break;

    default:
      die('IsValidTable not implemented for database type: '.$ASTRIA['databases'][$Alias]['type']);

  }

  return $IsTable;
}
