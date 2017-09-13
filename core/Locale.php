<?php

global $ASTRIA;

if(
  isset($ASTRIA)&&
  isset($ASTRIA['locale'])&&
  isset($ASTRIA['locale']['timezone'])
){

  date_default_timezone_set($ASTRIA['locale']['timezone']);

}
