<?php

Hook('Webhook','MaybeHandleAce();');

function ace($Code,$Class = '',$ID = ''){
  global $ASTRIA;
  //The purpose of this tool is to allow any code to be executed asynchronously and loaded into an object later. 
  
  //Create a unique high-entropy hash and store it along with the code into the key-value store
  //32 bits of base 62 has enough entropy to effectively require half the remaining lifespan of the universe to bruteforce, but feel free to change this if you want.
  $Hash=MakeRandomString(32);
  
  $Code = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],base64_encode($Code));
  
  Query("INSERT INTO `ACE` (`Hash`, `Code`) VALUES ('".$Hash."', '".$Code."');");
  
  //Create object to be returned
  
  $ACE='<div class="ace_'.$Hash.' '.$Class.'"';
  if(!($ID=='')){
    $ACE.=' id="'.$ID.'"';
  }
  $ACE.='><img src="/img/ajax-loader.gif"></div><script>$.get("/ace/'.$Hash.'",function(data){$(".ace_'.$Hash.'").html(data);});</script>';
  return $ACE;
}

function MaybeHandleAce(){
  if(path(0)=='ace'){
    handleAce(path(1));
    exit;
  }
}

function handleAce($Hash){
  global $ASTRIA;

  $Hash = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Hash);
  
  //Fetch matching code
  $Code = Query('SELECT Code FROM ACE WHERE Hash LIKE "'.$Hash.'"');
  
  //Delete entry once called
  Query("DELETE FROM `ACE` WHERE Hash LIKE '".$Hash."';");
  
  if(isset($Code[0]['Code'])){
    eval($Code[0]['Code']);
    exit;
  }
  die('Invalid ACE Hash.');
}
