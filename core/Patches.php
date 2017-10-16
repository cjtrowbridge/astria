<?php

Hook('Done Updating Astria','AstriaPatches();');

function AstriaPatches(){

 if($handle = opendir('core/patches')){
    while (false !== ($class = readdir($handle))){
      $include_path='core/patches/'.$class;
      if((!(strpos($class,'.php')===false)) && $class != "." && $class != ".." && file_exists($include_path)){
        Event('Before Loading Patch: '.$include_path);
        include_once($include_path);
        Event('After Loading Patch: '.$include_path);
      }
    }
    closedir($handle);
  }else{
    die('Unable to load patches directory!');
  }
  
  Event('Run Astria Patches');

}
