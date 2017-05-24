<?php

function FetchURL($URL, $Method = 'GET', $Arguments = false,$Authorization = false){
  
  if($URL==''){
    return false;
  }
  
  //Make sure method is uppercase
  $Method=strtoupper($Method);
  
  //Initialize Arguments array if null
  if($Arguments==false){
    $Arguments=array();
  }

  //Set up cURL  
  $cURL = curl_init();
  curl_setopt($cURL,CURLOPT_URL, $URL);
  
  //Maybe add arguments into POSTFIELDS
  if($Method=='POST'){
    curl_setopt($cURL,CURLOPT_POST, count($Arguments));
    $URLArguments = http_build_query($Arguments);
    curl_setopt($cURL,CURLOPT_POSTFIELDS, $URLArguments);
  }
  
  //Maybe pass authorization
  if($Authorization){
    curl_setopt($cURL,CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer '.$Token
    ));
  }
  
  if($Method=='PUT'){
    curl_setopt($cURL,CURLOPT_RETURNTRANSFER, false);
  }else{
    curl_setopt($cURL,CURLOPT_RETURNTRANSFER, true);
  }
  
  
  //Run cURL and close it
  $Data = curl_exec($cURL);
  curl_close($cURL);
  
  //Note: This function returns the data as it is received; it is not parsed.
  
  return $Data;
}
