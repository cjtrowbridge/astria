<?php 

include_once('core/Session.php');
include_once('core/Event.php');
include_once('core/Hook.php');

function Loader($dir = 'core',$DieOnFail = true){
  Event('Before Loading Directory: '.$dir);
  if($dir=='core'){
  
    if($handle = opendir('core')){
      while (false !== ($class = readdir($handle))){
        $include_path='core/'.$class;
        if((!(strpos($class,'.php')===false)) && $class != "." && $class != ".." && file_exists($include_path)){
          Event('Before Loading: '.$include_path);
          include_once($include_path);
          Event('After Loading: '.$include_path);
        }
      }
      closedir($handle);
    }
  
  }else{
    
    if(
      (!(file_exists($dir)))&&
      $DieOnFail
    ){
      die('Loader could not find dir: '.$dir);
    }
    
    if(file_exists($include_path=$dir.'/main.php'){
      Event('Before Loading: '.$include_path);
      include_once($include_path);
      Event('After Loading: '.$include_path);
    }
    
    if($handle = opendir($dir)){
      while (false !== ($extension = readdir($handle))){
        //$include_path=$dir.'/main.php';
        //if($extension != "." && $extension != ".." && file_exists($include_path)){
          //Event('Before Loading: '.$include_path);
          //include_once($include_path);
          //Event('After Loading: '.$include_path);
        //}else{
          if($extension != "." && $extension != ".." && is_dir($extension)){
            Event('Before Recursively Loading Subdirectory: '.$extension);
            Loader($dir.'/'.$extension);
            Event('After Recursively Loading Subdirectory: '.$extension);
          }
        //}
      }
      closedir($handle);
    }
    
  }
  Event('After Loading Directory: '.$dir);
}
