<?php

Hook('Webhook','RepoPull();');

function RepoPull(){
  
  //TODO figure out some kind of automated integration test to put in here
  
  $MagicWord=BlowfishEncrypt('Pull Mainline From Github');
  if(
    isset($_GET[$MagicWord])
  ){
    $Path=dirname(__FILE__);
    $Path=str_replace('/core','',$Path);
    
    $Command = 'cd '.$Path.' && git reset --hard && git pull';
    
    echo 'Pulling Mainline Repo...<br>';
    echo shell_exec($Command);
    
    exit;
  }
}
