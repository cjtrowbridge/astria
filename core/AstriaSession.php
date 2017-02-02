<?php

function AstriaSessionSetUp(){
  
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
