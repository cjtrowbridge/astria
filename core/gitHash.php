<?php

Hook('Before Login','GitMasterHash();');

function GitMasterHash(){
  if(isset($_GET['gitHash'])){
    die(gitHash());
  }
}

function gitLocalHash(){
  $Path=$_SERVER['DOCUMENT_ROOT'].'/.git/refs/heads/master';
  return gitHash($Path);
}
function gitGlobalHash(){
  $Hash = gitHash('https://api.github.com/repos/cjtrowbridge/astria/git/refs/heads/master');
  $Hash = json_decode($Hash,true);
  return $Hash;
}
  
function gitHash($Path){
  //if($Hash = file_get_contents($Path)){
  if($Hash = FetchURL($Path)){
    return $Hash;
  }else{
    return 'unknown';
  }
}
