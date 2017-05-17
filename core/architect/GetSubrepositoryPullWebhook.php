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
  
  
  
  die($Path);
  
  
  $Subrepository=BlowfishEncrypt();;
  $Path.=$Subrepository;

  echo $Path;
  exit;

}
