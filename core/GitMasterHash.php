<?php

Hook('Before Login','GitMasterHash();');

function GitMasterHash(){
  if(isset($_GET['gitHash'])){
    die(gitHash());
  }
}

function gitHash($Path = 'local'){
  if($Path=='local'){
    $Path=$_SERVER['DOCUMENT_ROOT'].'.git/refs/heads/master';
  }else{
    if(!(substr($Path, -1)=='/')){
      $Path=$Path.'/';
    }
    $Path.='?gitHash';
  }
  if($Hash = file_get_contents($Path)){
    return $Hash;
  }else{
    return 'unknown';
  }
}
