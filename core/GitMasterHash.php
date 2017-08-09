<?php

Hook('Before Login','GitMasterHash();');

function GitMasterHash(){
  if(isset($_GET['gitHash'])){
    die(gitHash());
  }
}

function gitHash(){
  if($Hash = file_get_contents('../.git/refs/heads/master')){
    return $Hash;
  }else{
    return 'unknown';
  }
}
