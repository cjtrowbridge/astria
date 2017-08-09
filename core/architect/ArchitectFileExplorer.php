<?php

function ArchitectFileExplorer(){
  TemplateBootstrap4('File Explorer - Architect','ArchitectFileExplorerBodyCallback();'); 

}

function ArchitectFileExplorerBodyCallback(){
  pd($_SERVER);
  return;
  $path='/var/www';
  
  $directories=array();
  $files=array();
  if($handle = opendir($path)){
    while(false !== ($entry = readdir($handle))){
      if(is_dir($path.DIRECTORY_SEPARATOR.$entry)){
        if(($entry !== '.')&& ($entry!=='..')){
          $directories[$entry]=$path.DIRECTORY_SEPARATOR.$entry;
        }
      }else{
        $files[$entry]=$path.DIRECTORY_SEPARATOR.$entry;
      }
    }
    closedir($handle);
  }
  asort($directories);
  asort($files);
  foreach($directories as $name => $directory){
    echo '<div><a href="'.$name.'"><img src="/icons/folder.gif" alt="[DIR]"> '.$name.'</a><br></div>';
  }
  foreach($files as $name => $file){
    echo '<div><a href="'.$name.'"><img src="/icons/unknown.gif" alt="[DIR]"> '.$name.'</a><br></div>';
  }
}
