<?php

function VerifyAgentAndIP(){
	//Make sure that the user agent and ip have not changed and that the sessions is not expired
	global $ASTRIA;
	
	if(!($ASTRIA['Session']['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
		AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
		AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['Auth']['Expires']>time())){
		AstriaSessionDestroy();
	}
}
