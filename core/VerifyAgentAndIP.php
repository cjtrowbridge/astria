<?php

function VerifyAgentAndIP(){
	//Make sure that the user agent and ip have not changed and that the sessions is not expired
	global $ASTRIA;
	
	if(!($ASTRIA['Session']['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
		if(isset($_GET['verbose'])){
			echo $ASTRIA['Session']['UserAgentHash'].'<br><br> DOES NOT MATCH<br><br>'.$_SERVER['HTTP_USER_AGENT'];
			exit;
		}
		AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
		if(isset($_GET['verbose'])){
			echo $ASTRIA['Session']['RemoteAddrHash'].'<br><br> DOES NOT MATCH<br><br>'.md5($_SERVER['REMOTE_ADDR']);
			exit;
		}
		AstriaSessionDestroy();
	}
	if(!($ASTRIA['Session']['Expires']>time())){
		if(isset($_GET['verbose'])){
			echo 'Session expired';
			exit;
		}
		AstriaSessionDestroy();
	}
}
