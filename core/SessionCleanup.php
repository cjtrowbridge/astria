<?php

function SessionCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) < 1){  
        if(strpos($file, 'session_')==1){
          unlink($path.$file);
        }
      }
    }
  }
}
