<?php

function GetAllMemberships($UserID){
  //Find the groups they are a member of, as well as all the ancestor groups
  $Memberships=array();
  $DirectMemberships = Query("SELECT DISTINCT(GroupID) FROM `UserMembership` WHERE UserID = ".intval($UserID));
    
    foreach($DirectMemberships as $DirectMembership){
      
      $Memberships[$DirectMembership['GroupID']]=$DirectMembership['GroupID'];
      
      $IndirectMemberships = GetGroupAncestors($DirectMembership['GroupID']);
      foreach($IndirectMemberships as $IndirectMembership){
        $Memberships[$IndirectMembership]=$IndirectMembership;
      }
      
    }
  ksort($Memberships);
  
  //The groups are in order but they are strings and some might be blank. Let's clean them up
  $CleanMemberships=array();
  foreach($Memberships as $Membership){
    $temp=trim(intval($Membership));
    if(!($temp=='')){
      $CleanMemberships[]=$temp;
    }
  }
  
  return $CleanMemberships;
}
