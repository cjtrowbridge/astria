<?php

function GetSubrepositoryPullWebhook(){
  if(!isset($_GET['path'])){
    die('Subdirectory path not specified.');
  }
  
  if(!is_dir($_GET['path'])){
    die('Invalid directory: '.$_GET['path']);
  }
  
  
  $Path=dirname(__FILE__);
  $Path=str_replace('/core/architect','',$Path);
  $Path.=$_GET['path'];
  die($Path);
  
  
  $Subrepository=BlowfishEncrypt();;
  $Path.=$Subrepository;

  echo $Path;
  exit;

}
