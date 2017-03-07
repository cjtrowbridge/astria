<?php

function HasMembership($Group,$UserID=''){

  if($UserID==''){
    global $USER;
    $UserID = $USER['UserID'];
  }
  
  //TODO add something to look up the id if a group name is passed
  $GroupID=intval($Group);
  
  if(!(isset($ASTRIA['Session']))){
    return false;
  }
  if(!(isset($ASTRIA['Session']['User']))){
    return false;
  }
  if(!(isset($ASTRIA['Session']['User']['Memberships']))){
    return false;
  }
  if(!(isset($ASTRIA['Session']['User']['Memberships'][$GroupID]))){
    return false;
  }
  
  
  if(($ASTRIA['Session']['User']['Memberships'][$GroupID]==$GroupID)){
    return true;
  }else{
    return false;
  }
  
}
