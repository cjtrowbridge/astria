<?php

define('DISK_CACHE_FILE_PREFIX','<?php /* ');
define('DISK_CACHE_FILE_SUFFIX',' */ header("HTTP/1.1 301 Moved Permanently");header("Location: /");');

function writeDiskCache($hash,$value){
  
  $value=var_export($value,true);
  
  $value=BlowfishEncrypt($value);
  $value=DISK_CACHE_FILE_PREFIX.$value.DISK_CACHE_FILE_SUFFIX;
  
  return file_put_contents('cache/'.$hash.'.php',$value);

}

function readDiskCache($hash,$ttl){
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
  
  eval('$return = ' . $value);

  return $return;
}
