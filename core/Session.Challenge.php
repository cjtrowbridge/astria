<?php

Hook('User Is Logged In - Before Presentation','MaybeChallengeSession();');


function MaybeChallengeSession(){
  if(
    IsAstriaAdmin() &&
    isset($_GET['challengeSession'])
  ){
    AstriaChallengeSession();
  }
}


function AstriaChallengeSession(){
  
  //We are skeptical of the user's session, challenge it.
  global $AstriaChallengeSession;
  $AstriaChallengeSession = false;
  
  include('core/Event.php');
  Event('Challenge Session');
  
  if($AstriaChallengeSession==false){
    AstriaSessionDestroy();
  }
  
}
