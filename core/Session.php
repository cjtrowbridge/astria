<?php

function AstriaSessionSetUp(){
  include_once('Query.php');
  include_once('MakeSureDBConnected.php');
  
  global $ASTRIA;
  //If there is not already a cookie and session, create one.
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  if(!(isset($_COOKIE[$CookieName]))){
    MakeSureDBConnected();
    
    //Create a random hash to connect the cookie with the session
    $SessionHash=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5(uniqid(true)));
    
    $ASTRIA['Session']['SessionHash']=$SessionHash;
    
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
    
    AstriaSessionSave();
    
  }else{
    
    include_once('VerifyAgentAndIP.php');
    include_once('Cache.php');
    $ASTRIA=ReadCache($_COOKIE[$CookieName],$ASTRIA['app']['defaultSessionLength']);
    pd($ASTRIA);exit;
    VerifyAgentAndIP();
    
  }
}

function AstriaSessionSave(){
  global $ASTRIA;
  include_once('Cache.php');
  WriteCache($ASTRIA['Session']['SessionHash'],$ASTRIA);
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
