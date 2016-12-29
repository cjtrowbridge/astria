<?php

function SessionCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) > $ASTRIA['app']['defaultSessionLength']){  
        if(strpos($file, 'session_')==0){
          //unlink($path.$file);
          echo 'deleted file: '.$file."<br>\n";
        }else{echo 'skipped nonsession file'.$file.": ".(strpos($file, 'session_'))."<br>\n";}
      }else{echo 'skipped fresh file '.$file." age: ".(time()-filectime($path.$file))."/ ".$ASTRIA['app']['defaultSessionLength']."<br>\n";}
    }
  }else{die('Cant open cache dir.');}
}
