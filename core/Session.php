<?php

AstriaSessionSetUp();

function AstriaSessionSetUp(){
  include_once('Query.php');
  include_once('MakeSureDBConnected.php');
  
  global $ASTRIA;
  //If there is not already a cookie and session, create one.
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  if(!(isset($_COOKIE[$CookieName]))){
    
    MakeSureDBConnected();
    
    $SessionHash         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5(uniqid(true)));
    $UserAgentHashClean  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['HTTP_USER_AGENT']));
    $UserAgentClean      = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['HTTP_USER_AGENT']);
    $UserIPHashClean     = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['REMOTE_ADDR']));
    $UserIPClean         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['REMOTE_ADDR']);
    $ExpiresTime         = (time()+$ASTRIA['app']['defaultSessionLength']);
    $Expires             = date('Y-m-d H:i:s',$ExpiresTime);
    
    if (!setcookie($CookieName, $SessionHash, $ExpiresTime, '/', NULL, true,true)){
      die('Could not set cookie.');
    }
    
    //Insert session into database
    Query("
      INSERT INTO `Session` 
      (`SessionHash`, `UserAgentHash`, `UserAgent`, `UserIPHash`, `UserIP`, `Expires`) VALUES 
      ('".$SessionHash."' , '".$UserAgentHashClean."', '".$UserAgentClean."', '".$UserIPHashClean."', '".$UserIPClean."', '".$Expires."');
    ");
    
    $ASTRIA['Session']=array(
      'SessionHash'    => $SessionHash,
      'UserAgentHash'  => md5($_SERVER['HTTP_USER_AGENT']),
      'RemoteAddrHash' => md5($_SERVER['REMOTE_ADDR']),
      'Expires' => $ExpiresTime,
      'Auth' => array(
        'Already Attempted' => false,
        'Logged In'         => false
      )
    );
    
    AstriaSessionSave();
    
  }else{
    
    include_once('VerifyAgentAndIP.php');
    include_once('Cache.php');
    include_once('pd.php');
    pd($_COOKIE[$CookieName]);
    $ASTRIA['Session']=ReadCache($_COOKIE[$CookieName],$ASTRIA['app']['defaultSessionLength']);
    VerifyAgentAndIP();
    
  }
}

function AstriaSessionSave(){
  global $ASTRIA;
  include_once('Cache.php');
  $CacheResult=WriteCache($ASTRIA['Session']['SessionHash'],$ASTRIA['Session']);
  if(isset($_GET['verbose'])){
    include_once('pd.php');
    echo '<h4>Cache result when saving session...</h4>';
    pd($CacheResult);
    if($_GET['verbose']=='AstriaSessionSave'){exit;}
  }
}

function AstriaSessionDestroy(){
  global $ASTRIA;
  $CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
  unset($_COOKIE[$CookieName]);
  setcookie($CookieName, null, -1, '/');
  include_once('Cache.php');
  DeleteCache($ASTRIA['Session']['SessionHash']);
  header('Location: /');	
  exit;
}
