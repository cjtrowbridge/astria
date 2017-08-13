<?php

function Sanitize($Input, $Database = 'astria', $Type = 'string'){
  global $ASTRIA;
  
  $Type = strtolower($Type);
  
  switch($Type){
    case 'int':
    case 'integer':
      return intval($Input);
    case 'string':
    default:
      MakeSureDBConnected($Database);
      return mysqli_real_escape_string($ASTRIA['databases'][Database]['resource'],$Input);
  }
}
