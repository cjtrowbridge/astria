<?php

function VerifyAgentAndIP(){
	//Make sure that the user agent and ip have not changed and that the sessions is not expired
	if(!($ASTRIA['Session']['UserAgentHash']  == md5($_SERVER['HTTP_USER_AGENT']))){
		LogOut();
	}
	if(!($ASTRIA['Session']['RemoteAddrHash'] == md5($_SERVER['REMOTE_ADDR']))){
		LogOut();
	}
	if(!($ASTRIA['Session']['Auth']['Expires']>time())){
		LogOut();
	}
}
