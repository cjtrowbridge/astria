<?php

function AstriaSessionSetUp(){
  //If there is not already a cookie and session, create one.
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  if(!(isset($_COOKIE[$CookieName]))){
    
    //Create a random hash to connect the cookie with the session
    $SessionHash=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5(uniqid(true)));
    
    if (!setcookie($CookieName, $SessionHash, $ExpiresTime, '/', NULL, true,true)){
      die('Could not set cookie.');
    }
    
    //Insert session into database
    $UserAgentHashClean  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['HTTP_USER_AGENT']));
    $UserAgentClean      = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['HTTP_USER_AGENT']);
    $UserIPHashClean     = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['REMOTE_ADDR']));
    $UserIPClean         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['REMOTE_ADDR']);
    $ExpiresTime         = (time()+$ASTRIA['app']['defaultSessionLength']);
    $Expires             = date('Y-m-d H:i:s',$ExpiresTime);
    Query("
      INSERT INTO `Session` 
      (`SessionHash`, `UserAgentHash`, `UserAgent`, `UserIPHash`, `UserIP`, `Expires`) VALUES 
      ('".$SessionHash."' , '".$UserAgentHashClean."', '".$UserAgentClean."', '".$UserIPHashClean."', '".$UserIPClean."', '".$Expires."');
    ");
    
  }
  
	
	
  
  
}
function AstriaSessionSave(){
  
}
function AstriaSessionDestroy(){
  global $ASTRIA;
	session_destroy();
	$CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
	unset($_COOKIE[$CookieName]);
  setcookie($CookieName, null, -1, '/');
	deleteDiskCache($ASTRIA['Session']['SessionHash']);
	header('Location: /');	
	exit;
}
