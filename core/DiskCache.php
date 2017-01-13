<?php

define('DISK_CACHE_FILE_PREFIX','<?php /* ');
define('DISK_CACHE_FILE_SUFFIX',' */ header("HTTP/1.1 301 Moved Permanently");header("Location: /");');
define('DISKCACHETTL',60*60*24*7);

function deleteDiskCache($hash){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){
    return false;
  }
  $path='cache/'.$hash.'.php';
  
  if(!(file_exists($path))){
    return false;
  }
  unlink($path);
  return true;
}
  
function writeDiskCache($hash,$value){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){
    return false;
  }
  
  $value=var_export($value,true);
  
  $value=BlowfishEncrypt($value);
  $value=DISK_CACHE_FILE_PREFIX.$value.DISK_CACHE_FILE_SUFFIX;
  
  return file_put_contents('cache/'.$hash.'.php',$value);

}

function readDiskCache($hash,$ttl = DISKCACHETTL){
  include_once('core/isValidMd5.php');
  if(!(isValidMd5($hash))){
    return false;
  }
  
  $path='cache/'.$hash.'.php';
  
  if(!(file_exists($path))){
    return false;
  }
  
  if((filemtime($path)+$ttl)>time()){
    unlink($path);
    return false;
  }
  
  $value=file_get_contents($path);
  $value=ltrim($value,DISK_CACHE_FILE_PREFIX);
  $value=rtrim($value,DISK_CACHE_FILE_SUFFIX);
  
  $value=BlowfishDecrypt($value);
  
  $eval="\$return = " . $value;
  pd($eval);
  eval($eval);

  return $return;
}

function DiskCacheCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) > DISKCACHETTL){  
        if(!(strpos($file, '.php')===false)){
          unlink($path.$file);
        }
      }
    }
  }
}

function DiskCacheExists($hash){
 if(!(isValidMd5($hash))){
    return false;
  }
  $path='cache/'.$hash.'.php';
  
  if(!(file_exists($path))){
    return false;
  }
  return true;
}
