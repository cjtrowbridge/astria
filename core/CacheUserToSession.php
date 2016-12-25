<?php

function CacheUserToSession($email=null){
  if($email == null){
    die('Tried to cache invalid user.');
  }
  
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SESSION['google_oauth2']['user_object']->email);
  
  $User=Query("SELECT UserID,Email,FirstName,LastName,Photo FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1")[0]; 
  $_SESSION['User']=$User;
  
  $Memberships=array();
  $DirectMemberships = Query("SELECT DISTINCT(GroupID) FROM `Membership` WHERE UserID = ".$_SESSION['User']['UserID']);
    
    foreach($DirectMemberships as $DirectMembership){
      
      $Memberships[$DirectMembership['GroupID']]=$DirectMembership['GroupID'];
      
      $IndirectMemberships = GetGroupAncestors($DirectMembership['GroupID']);
      foreach($IndirectMemberships as $IndirectMembership){
        $Memberships[$IndirectMembership]=$IndirectMembership;
      }
      
    }
  ksort($Memberships);
  
  //These are in order but they are strings and some might be blank. Let's clean them up
  $CleanMemberships=array();
  foreach($Memberships as $Membership){
    $temp=trim(intval($Membership));
    if(!($temp=='')){
      $CleanMemberships[]=$temp;
    }
  }
  
  //Cache them to the session
  $_SESSION['User']['Memberships']=$CleanMemberships;
  
}
function GetGroupAncestors($GroupID){
  $Ancestors = array();
  while(true){
    $Output= Query('SELECT ParentID FROM `Group` WHERE GroupID = '.intval($GroupID));
    
    if(count($Output)==0){
      break;
    }
    $GroupID=$Output[0]['ParentID'];
    $Ancestors[]=$GroupID;
  }
  
  return $Ancestors;
}
