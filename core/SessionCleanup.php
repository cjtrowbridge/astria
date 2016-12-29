<?php

function SessionCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) < 1){  
        if(strpos($file, 'session_')==1){
          unlink($path.$file);
        }else{echo 'skipped nonsession file'.$file."<br>\n";}
      }else{echo 'skipped fresh file '.$file."<br>\n";}
    }
  }else{die('Cant open cache dir.');}
}
