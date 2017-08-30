<?php

include_once('core/Hook.php');
Hook('User Is Logged In','MaybeChallengeSession();');

function MaybeChallengeSession(){
  if(isset($_GET['challengeSession'])){
    AstriaChallengeSession();
    exit;
  }
}

function AstriaChallengeSession(){
  
  //We are skeptical of the user's session, challenge it.
  global $AstriaChallengeSession;
  
  $AstriaChallengeSession = false;
  
  Event('Challenge Session');
  
  if($AstriaChallengeSession==false){
    AstriaSessionDestroy();
  }
  
}
