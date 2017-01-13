<?php 

function showArchitectDiskCache(){
  if(path(2)=='delete-all'){
    //TODO
  }
  Hook('Template Body',"ArchitectDiskCache();");
  TemplateBootstrap2('View Cache - Architect'); 
}

function ArchitectDiskCache(){
  ?>
  <h2>Disk Cache</h2>
  <a href="/architect/disk-cache/delete-all">Delete All</a>
  <?php
    global $ASTRIA;
    $path = 'cache/';
    if ($handle = opendir($path)) {
      while (false !== ($file = readdir($handle))) {
        if(!(strpos($file, '.php')===false)){
          $hash = rtrim($file,'.php');
          if(!($hash == 'index')){
            echo '<a href="/architect/disk-cache/'.$hash.'">'.$hash.'</a> ('.(filesize($path.$file)/1024).'kb)<br>';
          }
        }
      }
    }
}
