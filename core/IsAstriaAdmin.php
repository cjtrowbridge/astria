<?php


function IsAstriaAdmin(){
  //TODO
  global $ASTRIA;
  if(!(isset($ASTRIA['Session']))){
   return false; 
  }
  if(!(isset($ASTRIA['Session']['User']))){
   return false; 
  }
  if(!(isset($ASTRIA['Session']['User']['UserID']))){
   return false; 
  }
  if($ASTRIA['Session']['User']['UserID']==1){
    return true;
  }else{
    return false;
  }
}
