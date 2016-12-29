<?php 

session_start();

//We need this to happen before this script can work
include_once('Path.php');

//TODO make this happen on a cron
include_once('DiskCache.php');
DiskCacheCleanup();

if(
	path()=='logout'||
	isset($_GET['logout'])  
){
	LogOut();
}

if(
	isset($_SESSION['Auth'])&&
	($_SESSION['Auth']['Expires']>time())
){
	
}else{
	
	//Check for disk session cache with current session's cookie hash if present.
	global $ASTRIA;
	$CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
	if(isset($_COOKIE[$CookieName])){
		$Cache=readDiskCache($_COOKIE[$CookieName],$ASTRIA['app']['defaultSessionLength']);
	}else{
		$Cache=false;	
	}
	
	if($Cache==false){
		$_SESSION['Auth']=array(
			'Logged In'		=> false,
			'Last Validated'	=> 0,
			'Expires'		=> 0,
			'Already Attempted'	=> false
		);
	}else{
		$_SESSION=$Cache;
	}
	
}

//Make sure that the user agent and ip have not changed and that the sessions is not expired
if(!($_SESSION['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
	LogOut();
}
if(!($_SESSION['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
	LogOut();
}
if(!($_SESSION['Auth']['Expires']>time())){
	LogOut();
}

function LoggedIn(){
    	if(!(isset($_SESSION['Auth']['Already Attempted']))){
		LogOut();
	}
	
	if($_SESSION['Auth']['Already Attempted']==true){
		return $_SESSION['Auth']['Logged In'];
	}
	/*
	
		This function determines whether the user is logged in and returns true or false
	
	*/
	
	//check for a current session and determine whether the user has one
	Event('Verify Session');
	
	if($_SESSION['Auth']['Logged In']==true){
		
		//we already checked and the user is logged in!
		return true;
		
	}else{
	  
    //we need to attempt to authorize the user. one of the called hooks should change the 'Logged In' to true if it was able to authorize the user.
    Event('Attempt Auth');
    $_SESSION['Auth']['Already Attempted']=true;
	  
    //check whether we were sucesful in authorizing the user
    if($_SESSION['Auth']['Logged In']==true){
      return true;
    }else{
      return false;
    }
			
  }
  
}
function LogOut(){
	session_destroy();
	$CookieName=strtolower($ASTRIA['app']['appName']).'_'.md5($ASTRIA['app']['appURL']);
	unset($_COOKIE[$CookieName]);
    	setcookie($CookieName, null, -1, '/');
	deleteDiskCache($_SESSION['SessionHash']);
	header('Location: /');	
	exit;
}
