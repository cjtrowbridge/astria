<?php

function IsWaiting(){
  global $ASTRIA;
  
  if(!(isset($ASTRIA['Session']))){return false;}
  if(!(isset($ASTRIA['Session']['User']))){return false;}
  if(!(isset($ASTRIA['Session']['User']['IsWaiting']))){return false;}
  
  if($ASTRIA['Session']['User']['IsWaiting']==1){
    return true;
  }else{
    return false;
  }
}
