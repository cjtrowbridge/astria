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
  return gitHash('https://api.github.com/repos/cjtrowbridge/astria/git/refs/heads/master');
}
  
function gitHash($Path){
  if($Hash = file_get_contents($Path)){
    return $Hash;
  }else{
    return 'unknown';
  }
}
