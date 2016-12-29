<?php

function writeDiskCache($hash,$value){
  
  $value=var_export($value,true);
  
  $value=BlowfishEncrypt($value);
  $value="<?php //".$value;
  
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
  $value=ltrim($value,"<?php //");
  $value=BlowfishDecrypt($value);
  
  eval('$return = ' . $value);

  return $return;
}
