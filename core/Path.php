<?php

function path($index = 0,$Lowercase = true){
  $pathSegments = paths($Lowercase);
  if(isset($pathSegments[$index])){
    if(trim($pathSegments[$index])==''){
      return false;
    }else{
      return $pathSegments[$index];
    }
  }else{
    return false;
  }
}

function paths($Lowercase = true){
  $theURL=url($Lowercase);
  
  //If there is a question mark, truncate the url we are parsing at that point.
  $PreQ = explode("?", $theURL);
  $theURL = $PreQ[0];
  
  if(!(substr($theURL, -1)=='/')){$theURL.='/';}
  $pathSegments = explode('/', $theURL);
  $output = array();
  foreach($pathSegments as $pathSegment){
    if(!(trim($pathSegment)=='')){
      $output[]=$pathSegment;
    }
  }
  return $output;
}

function url($Lowercase = true){
  $URL = rtrim(trim($_SERVER['REQUEST_URI'], '/'),'/');
  
  if($Lowercase){
    $URL = strtolower($URL);
  }
  
  return $URL;
}
