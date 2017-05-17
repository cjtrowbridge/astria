<?php

Hook('Webhook','WebhookPullSubrepository();');

function WebhookPullSubrepository(){
  $MagicWord=BlowfishEncrypt('Pull Subrepository From Github');
  if(
    isset($_GET[$MagicWord])
  ){
    $Path=dirname(__FILE__);
    $Path=str_replace('/core','',$Path);
    $Subrepository=BlowfishDecrypt($_GET[$MagicWord]);;
    $Path.=trim($Subrepository);
    
    echo 'Pulling Subrepository: '.$Path.'<br>';
    
    if(!is_dir($Path)){
      die('Path not found: '.$Path);
    }
    
    $Command = 'cd '.$Path.' && git reset --hard && git pull';
    echo $Command;
    echo shell_exec($Command);
    
    exit;
  }
}
