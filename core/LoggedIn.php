<?php 

session_start();

//We need this to happen before this script can work
include_once('Path.php');

if(
	path()=='logout'||
	isset($_GET['logout'])  
){
	session_destroy();
	header('Location: ./');
	exit;
}

if(
	isset($_SESSION['Auth'])&&
	($_SESSION['Auth']['Expires']>time())
){
	
}else{
	$_SESSION['Auth']=array(
		'Logged In'		=> false,
		'Last Validated'	=> 0,
		'Expires'		=> 0,
		'Already Attempted'	=> false
	);
}

function LoggedIn(){
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
    $_SESSION['Auth']['Already Attempted']==true;
	  
    //check whether we were sucesful in authorizing the user
    if($_SESSION['Auth']['Logged In']==true){
      return true;
    }else{
      return false;
    }
			
  }
  
}
