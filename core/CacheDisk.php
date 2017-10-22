<?php

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
  include_once('core/Blowfish.php');
  if(!(isValidMd5($hash))){
    return false;
  }
  
  $value=serialize($value);
  
  $value=BlowfishEncrypt($value);
  $value=CACHE_FILE_PREFIX.$value.CACHE_FILE_SUFFIX;
  
  return file_put_contents('cache/'.$hash.'.php',$value);

}

function readDiskCache($hash,$ttl = CACHE_FILE_TTL){
  include_once('core/isValidMd5.php');
  include_once('core/Blowfish.php');
  if(!(isValidMd5($hash))){
    return false;
  }
  
  $path='cache/'.$hash.'.php';
  
  if(!(file_exists($path))){
    return false;
  }
  
  if((filemtime($path)+$ttl)<time()){
    unlink($path);
    return false;
  }
  
  $value=file_get_contents($path);
  if($value==false){
    return false; 
  }
  $value=ltrim($value,CACHE_FILE_PREFIX);
  $value=rtrim($value,CACHE_FILE_SUFFIX);
  
  $value=BlowfishDecrypt($value);
  
  $return=unserialize($value);
  
  global $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE;
  $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE+=1;
  
  return $return;
}

function DiskCacheCleanup(){
  global $ASTRIA;
  $path = 'cache/';
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))) {
      if ((time()-filectime($path.$file)) > CACHE_FILE_TTL){  
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
