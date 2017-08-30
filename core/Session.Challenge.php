<?php

//TODO add hooks to this from the verify ip and agent script

include_once('core/Hook.php');
Hook('User Is Logged In','MaybeChallengeSession();');

function MaybeChallengeSession(){
  if(isset($_GET['challengeSession'])){
    AstriaChallengeSession();
    exit;
  }
}

function AstriaChallengeSession(){
  //If for some reason we are skeptical of the user's session, challenge it.
  Event('Challenge Session');
}
