<?php

Hook('Before Login','GitMasterHash();');
  
function GitMasterHash(){
  if(isset($_GET['gitHash'])){
    if($Hash = file_get_contents('../.git/refs/heads/master'))){
      die($Hash);
    }else{
      die('unknown');
    }
  }
}
