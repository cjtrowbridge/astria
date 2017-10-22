<?php

function OutputJSON($Arr){
  header("Content-Type: application/json;charset=utf-8");
  $Output=json_encode($Arr,JSON_PRETTY_PRINT);
  if($Output==false){
    $Output = array('error'=>'There was a problem with the data.');
  }
  echo $Output;
  exit;
}
