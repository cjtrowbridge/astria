<?php

function VerifyAgentAndIP(){
	include_once('core/Session.Challenge.php');
	//Make sure that the user agent and ip have not changed and that the sessions is not expired
	global $ASTRIA;
	
	if($ASTRIA['Session']==null){
		//die('Session was null');
		//This probably should only happen the first time you load the configuration page's post-handler, but it's difficult to be sure of that. For now, leave this blank.
	}
	
	
	if(!($ASTRIA['Session']['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
		Event('HTTP_USER_AGENT does not match. Destorying Session.');
		AstriaChallengeSession();
		//AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
		Event('REMOTE_ADDR does not match. Challenging session with available providers...');
		AstriaChallengeSession();
		//AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['Expires']>time())){
		Event('Session is expired. Challenging session with available providers...');
		AstriaChallengeSession();
		//AstriaSessionDestroy();
	}
}
