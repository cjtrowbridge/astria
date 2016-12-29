<?php

function AuthenticateUser($email=null){
  global $ASTRIA;
  
  //Validate and sanitize the email
  if($email == null){die('Tried to cache invalid user.');}
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SESSION['google_oauth2']['user_object']->email);
  
  //Get all the user's profile info for the session
  $User=Query("SELECT UserID,Email,FirstName,LastName,Photo FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1")[0]; 
  $_SESSION['User']=$User;
  
  //Insert group memberships into the session
  $_SESSION['User']['Memberships']=GetAllGroups($_SESSION['User']['UserID']);
  
  //Create a high-entropy hash to connect the cookie with the session
  $SessionHash=mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5(uniqid(true)));
  
  //Insert session into database
  $UserIDClean         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$User['UserID']);
  $UserAgentHashClean  = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5($_SERVER['HTTP_USER_AGENT']));
  $UserAgentClean      = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SERVER['HTTP_USER_AGENT']);
  $UserIPHashClean     = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],md5($_SERVER['REMOTE_ADDR']));
  $UserIPClean         = mysqli_real_escape_string($ASTRIA['databases']['astria core administrative database']['resource'],$_SERVER['REMOTE_ADDR']);
  $ExpiresTime         = (time()+$ASTRIA['app']['defaultSessionLength']);
  $Expires             = date('Y-m-d H:i:s',$ExpiresTime);
  Query("
    INSERT INTO `Session` 
    (`SessionHash`, `UserID`, `UserAgentHash`, `UserAgent`, `UserIPHash`, `UserIP`, `Expires`) VALUES 
    ('".$SessionHash."' , ".$UserIDClean.", '".$UserAgentHashClean."', '".$UserAgentClean."', '".$UserIPHashClean."', '".$UserIPClean."', '".$Expires."');
  ");
  
  //Insert hash of user agent and IP into session for security checks
  $_SESSION['SessionHash']    = $SessionHash;
  $_SESSION['UserAgentHash']  = md5($_SERVER['HTTP_USER_AGENT']);
  $_SESSION['RemoteAddrHash'] = md5($_SERVER['REMOTE_ADDR']);
  
  //Insert the session hash into a secure cookie
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  if (!setcookie($CookieName, $SessionHash, $ExpiresTime, '/', NULL, true,true)){
    die('Could not set cookie.');
  }
  
  //Update the expiration date
  $_SESSION['Auth']['Expires'] = $ExpiresTime;
  
  //Cache the entire session to disk with the cookie's SessionHash as the key.
  writeDiskCache($SessionHash,$_SESSION);
  
}
