<?php

function GitMasterHash(){
  if($hash = file_get_contents('.git/refs/heads/master'))){
    return $hash;
  }else{
    return false;
  }
}
