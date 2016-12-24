<?php

global $ASTRIA;

if(
  isset($ASTRIA['debugging']) &&
  isset($ASTRIA['debugging']['showErrors']) &&
  $ASTRIA['debugging']['showErrors']==true
){
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
}
