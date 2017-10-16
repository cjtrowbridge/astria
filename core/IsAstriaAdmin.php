<?php

function IsAstriaAdmin(){
  global $ASTRIA;
  if($ASTRIA['Session']['User']['IsAstriaAdmin']==1){
    return true;
  }else{
    return false;
  }
}
