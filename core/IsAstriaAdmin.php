<?php

function IsAstriaAdministrator(){
  return IsAstriaAdmin();
}

function IsAstriaAdmin(){
  global $ASTRIA;
  
  if(!(isset($ASTRIA['Session']))){return false;}
  if(!(isset($ASTRIA['Session']['User']))){return false;}
  if(!(isset($ASTRIA['Session']['User']['IsAstriaAdmin']))){return false;}
  
  if($ASTRIA['Session']['User']['IsAstriaAdmin']==1){
    return true;
  }
  
  return false;
}
