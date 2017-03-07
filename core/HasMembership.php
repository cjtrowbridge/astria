<?php

function HasMembership($UserID,$Group){
  
  //TODO add something to look up the id if a group name is passed
  $GroupID=intval($Group);
  
  if(($ASTRIA['Session']['User']['Memberships'][$GroupID]==$GroupID)){
    return true;
  }else{
    return false;
  }
  
}
