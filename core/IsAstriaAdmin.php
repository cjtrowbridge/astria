<?php


function IsAstriaAdmin(){
  //TODO
  global $ASTRIA;
  if($ASTRIA['Session']['User']['UserID']==1){
    return true;
  }else{
    return false;
  }
}
