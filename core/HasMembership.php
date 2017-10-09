<?php

function HasMembership($Group,$UserID=''){
  global $ASTRIA;
  
  if($UserID==''){
    global $USER;
    $UserID = $USER['UserID'];
  }
  
  if(intval($Group)==$Group){
    $Group = Sanitize($Group);
    $FoundGroup = Query('SELECT * FROM UserGroup WHERE Name LIKE "'.$Group.'"');
    if(!(isset($FoundGroup[0]))){
      die('UserGroup '.$Group.' Not Found');
    }
    $Group = $FoundGroup[0]['GroupID'];
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
