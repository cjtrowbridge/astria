<?php 

function Loader($dir = 'core'){
  if($dir=='core'){
  
    if($handle = opendir('core')){
      while (false !== ($class = readdir($handle))){
        $include_path='core/'.$class;
        if($class != "." && $class != ".." && file_exists($include_path)){
          include_once($include_path);
        }
      }
      closedir($handle);
    }
  
  }else{
    
    if(!(file_exists($dir))){
      die('Loader could not find dir: '.$dir);
    }
    
    if($handle = opendir($dir)){
      while (false !== ($extension = readdir($handle))) {
        
        
        $include_path=$dir.'/main.php';
        if($extension != "." && $extension != ".." && file_exists($include_path)){
          Event('Before Loading: '.$include_path);
          include_once($include_path);
          Event('After Loading: '.$include_path);
        }else{
          if($extension != "." && $extension != ".." && is_dir($include_path)){
            Loader($include_path);
          }
        }
      }
      closedir($handle);
    }
    
  }
}
