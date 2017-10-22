<?php

Hook('Before Login','GitMasterHash();');

function GitMasterHash(){
  if(isset($_GET['gitHash'])){
    die(gitLocalHash());
  }
}

function gitLocalHash(){
  $Path=$_SERVER['DOCUMENT_ROOT'].'/.git/refs/heads/master';
  return gitHash($Path);
}
function gitGlobalHash(){
  
  $Hash = FetchURL('https://astria.io/?gitHash');
  return trim($Hash);
  
  $Hash = FetchURL('https://api.github.com/repos/cjtrowbridge/astria/git/refs/heads/master');
  $Hash = json_decode($Hash,true);
  if($Hash==false){return false;}
  if(!(isset($Hash['object']))){return false;}
  if(!(isset($Hash['object']['sha']))){return false;}
  return trim($Hash['object']['sha']);
}
  
function gitHash($Path){
  if($Hash = file_get_contents($Path)){
    return trim($Hash);
  }else{
    return 'unknown';
  }
}
