<?php

function path($index = 0){
  $pathSegments = paths();
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

function paths(){
  $pathSegments = explode('/', url());
  $output = array();
  foreach($pathSegments as $pathSegment){
    if(!(trim($pathSegment)=='')){
      $output[]=$pathSegment;
    }
  }
  return $output;
}

function url(){
  return ltrim(strtolower($_SERVER['REQUEST_URI']), '/');
}
