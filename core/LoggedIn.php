<?php 

//We need this to happen before this script can work
include_once('Path.php');
include_once('Session.php');

//TODO make this happen on a cron
include_once('DiskCache.php');
DiskCacheCleanup();

AstriaSessionSetUp();

if(
	path()=='logout'||
	isset($_GET['logout'])  
){
	LogOut();
}

if(
	isset($ASTRIA['Session']['Auth'])&&
	($ASTRIA['Session']['Expires']>time())
){
	VerifyAgentAndIP();
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
		$ASTRIA['Session']['Expires']		= 0;
		$ASTRIA['Session']=array(
			'Auth'=>array(
				'Logged In'		=> false,
				'Last Validated'	=> 0,				
				'Already Attempted'	=> false
			)
		);
	}else{
		$ASTRIA['Session']=$Cache;
		VerifyAgentAndIP();
	}
	
}



function LoggedIn(){
	global $ASTRIA;
    	if(!(isset($ASTRIA['Session']['Auth']['Already Attempted']))){
		AstriaSessionDestroy();
	}
	
	if($ASTRIA['Session']['Auth']['Already Attempted']==true){
		return $ASTRIA['Session']['Auth']['Logged In'];
	}
	/*
	
		This function determines whether the user is logged in and returns true or false
	
	*/
	
	//check for a current session and determine whether the user has one
	Event('Verify Session');
	
	if($ASTRIA['Session']['Auth']['Logged In']==true){
		
		//we already checked and the user is logged in!
		return true;
		
	}else{
	  
    //we need to attempt to authorize the user. one of the called hooks should change the 'Logged In' to true if it was able to authorize the user.
    Event('Attempt Auth');
    $ASTRIA['Session']['Auth']['Already Attempted']=true;
	  
    //check whether we were sucesful in authorizing the user
    if($ASTRIA['Session']['Auth']['Logged In']==true){
      return true;
    }else{
      return false;
    }
			
  }
  
}
