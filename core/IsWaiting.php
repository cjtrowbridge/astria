<?php

function IsWaiting(){
  global $ASTRIA;
  if($ASTRIA['Session']['User']['IsWaiting']==1){
    return true;
  }else{
    return false;
  }
}
