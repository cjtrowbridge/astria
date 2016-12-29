<?php

function AuthenticateUser($email=null){
  global $ASTRIA;
  
  if($email == null){die('Tried to cache invalid user.');}
  
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
  
  //Cache group memberships to the session
  $_SESSION['User']['Memberships']=$CleanMemberships;
  
  
  //Insert session into database
  
  $UserIDClean         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$User['UserID']);
  $UserAgentHashClean  = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5($_SERVER['HTTP_USER_AGENT']));
  $UserAgentClean      = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SERVER['HTTP_USER_AGENT']);
  $UserIPHashClean     = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5($_SERVER['REMOTE_ADDR']));
  $UserIPClean         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SERVER['REMOTE_ADDR']);
  $ExpiresTime         = (time()+$ASTRIA['app']['defaultSessionLength']);
  $Expires             = date('Y-m-d H:i:s',$ExpiresTime);
  
  $SessionHash=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5(uniqid(true)));
  
  Query("
    INSERT INTO `Session` 
    (`SessionHash`, `UserID`, `UserAgentHash`, `UserAgent`, `UserIPHash`, `UserIP`, `Expires`) VALUES 
    ('".$SessionHash."' , ".$UserIDClean.", '".$UserAgentHashClean."', '".$UserAgentClean."', '".$UserIPHashClean."', '".$UserIPClean."', '".$Expires."');
  ");
  
  $_SESSION['SessionHash']=$SessionHash;
  
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  if (!setcookie($CookieName, $SessionHash, $ExpiresTime, '/', NULL, true,true)){
    die('Could not set cookie.');
  }
  
  writeDiskCache($SessionHash,$_SESSION);
  
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
