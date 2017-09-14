<?php

Hook('Webhook','WebhookPullSubrepository();');

function WebhookPullSubrepository(){
  
  //TODO figure out some kind of automated integration test to put in here
  
  $MagicWord=BlowfishEncrypt('Pull Subrepository From Github');
  if(
    isset($_GET[$MagicWord])
  ){
    $Path=dirname(__FILE__);
    $Path=str_replace('/core','',$Path);
    $Subrepository=BlowfishDecrypt($_GET[$MagicWord]);;
    $Path.=trim($Subrepository);
    
    echo '<p>Pulling Subrepository: '.$Path.'</p>';
    
    if(!is_dir($Path)){
      die('Path not found: '.$Path);
    }
    
    $Command = 'cd '.$Path.' && git reset --hard && git pull';
    echo '<p>'.$Command.'</p><pre>';
    echo shell_exec($Command);
    echo '</pre>';
    
    exit;
  }
}
