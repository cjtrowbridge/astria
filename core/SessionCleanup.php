<?php

function SessionCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) > $ASTRIA['app']['defaultSessionLength']){  
        if(strpos($file, 'session_')==0){
          unlink($path.$file);
        }
      }
    }
  }else{die('Cant open cache dir. Please make sure it has the correct permissions.');}
}
