<?php

/*
TODO sessions need to be automatically refreshed from the database every minute or so before parallelism and clustering can really happen
  TODO let astria track when it last challenged the user's session and automatically challenge again periodically (depends on first item
*/

AstriaSessionSetUp();

function AstriaSessionSetUp(){
  include_once('Query.php');
  include_once('MakeSureDBConnected.php');
  include_once('Event.php');
  
  global $ASTRIA;
  //If there is not already a cookie and session, create one.
  $CookieName=strtolower(md5($ASTRIA['app']['appURL']));
  Event('Looking For Cookie: '.$CookieName);
  if(!(isset($_COOKIE[$CookieName]))){
    
    Event('Creating New Session');
    
    MakeSureDBConnected();
    
    if(!(isset($_SERVER['HTTP_USER_AGENT']))){
      $_SERVER['HTTP_USER_AGENT']='None';
    }
    
    $SessionHash         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5(uniqid(true)));
    $UserAgentHashClean  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['HTTP_USER_AGENT']));
    $UserAgentClean      = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['HTTP_USER_AGENT']);
    $UserIPHashClean     = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],md5($_SERVER['REMOTE_ADDR']));
    $UserIPClean         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SERVER['REMOTE_ADDR']);
    $ExpiresTime         = (time()+$ASTRIA['app']['defaultSessionLength']);
    $Expires             = date('Y-m-d H:i:s',$ExpiresTime);
    
    if (!setcookie($CookieName, $SessionHash, $ExpiresTime, '/', NULL, true,true)){
      die('Could not set cookie: "'.$CookieName.'".');
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
    Event('Current Session Hash: '.$_COOKIE[ strtolower(md5($ASTRIA['app']['appURL'])) ]);
    
    include_once('VerifyAgentAndIP.php');
    include_once('Cache.php');
    
    Event('Loading Saved Session Data');
    $ASTRIA['Session']=ReadCache($_COOKIE[$CookieName],$ASTRIA['app']['defaultSessionLength']);
    Event('Verifying Session...');
    VerifyAgentAndIP();
    EVent('Session Verified.');
  }
}

function AstriaSessionSave(){
  global $ASTRIA;
  include_once('core/Event.php');
  //Event('Saving Session...'.$_COOKIE[ strtolower(md5($ASTRIA['app']['appURL'])) ]);
  include_once('Cache.php');
  $CacheResult=WriteCache($ASTRIA['Session']['SessionHash'],$ASTRIA['Session']);
  if(isset($_GET['verbose'])){
    include_once('pd.php');
    echo '<b>Cache result when saving session...</b>';
    pd($CacheResult);
    if($_GET['verbose']=='AstriaSessionSave'){exit;}
    
  }
  //Event('Done Saving Session: '.$_COOKIE[ strtolower(md5($ASTRIA['app']['appURL'])) ]);;
}

function AstriaSessionDestroy(){
  Event('Destroying Sesion');
  global $ASTRIA;
  $CookieName=strtolower(md5($ASTRIA['app']['appURL']));
  unset($_COOKIE[$CookieName]);
  setcookie($CookieName, null, -1, '/');
  include_once('Cache.php');
  Query("DELETE FROM Session WHERE SessionHash LIKE '".$ASTRIA['Session']['SessionHash']."'");
  DeleteCache($ASTRIA['Session']['SessionHash']);
  header('Location: /');	
  exit;
}


Hook('Daily Cron','SessionCron();');

function SessionCron(){
  Query("DELETE FROM `Session` WHERE Expires < NOW()");
}
