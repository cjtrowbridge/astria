<?php 

//We need this to happen before this script can work
include_once('Path.php');
include_once('Session.php');

//TODO make this happen on a cron
include_once('DiskCache.php');
DiskCacheCleanup();

if(
	path()=='logout'||
	isset($_GET['logout'])  
){
	LogOut();
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
