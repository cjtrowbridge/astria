<?php

function GetSubrepositoryPullWebhook(){
  $Path=dirname(__FILE__);
  $Path=str_replace('/core/architect','',$Path);
  $Path.=$_GET['path'];
  
  
  if(!isset($Path)){
    die('Subdirectory path not specified.');
  }
  
  if(!is_dir($Path)){
    die('Invalid directory: '.$_GET['path']);
  }
  
  
  $MagicWord=BlowfishEncrypt('Pull Subrepository From Github');
  $MagicPath=BlowfishEncrypt($_GET['path']);
  
  global $ASTRIA;
  $URL=$ASTRIA['app']['appURL'].'/?'.urlencode($MagicWord).'='.urlencode($MagicPath);

  
  die($URL);
  
}
