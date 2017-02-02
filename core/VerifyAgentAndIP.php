<?php

function VerifyAgentAndIP(){
	//Make sure that the user agent and ip have not changed and that the sessions is not expired
	global $ASTRIA;
	
	if(!($ASTRIA['Session']['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
		echo $ASTRIA['Session']['UserAgentHash'].'<br><br> DOES NOT MATCH<br><br>'.$_SERVER['HTTP_USER_AGENT'];
		pd($ASTRIA['Session']);
		exit;//AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
		echo $ASTRIA['Session']['RemoteAddrHash'].'<br><br> DOES NOT MATCH<br><br>'.$_SERVER['REMOTE_ADDR'];
		exit;//AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['Expires']>time())){
		echo 'Session expired';
		include_once('pd.php');
		pd($ASTRIA['Session']);
		exit;//AstriaSessionDestroy();
	}
}
