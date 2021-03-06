<?php

Hook('Before Login','MaybeHandleAce();');

function ace($Code,$Class = '',$ID = '',$LoadingMessage = ''){
  global $ASTRIA;
  //The purpose of this tool is to allow any code to be executed asynchronously and loaded into an object later. 
  
  //Create a unique high-entropy hash and store it along with the code into the key-value store
  //32 bits of base 62 has enough entropy to effectively require half the remaining lifespan of the universe to bruteforce, but feel free to change this if you want.
  $Hash=MakeRandomString(32);
  
  $Code = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],base64_encode($Code));
  
  Query("INSERT INTO `ACE` (`Hash`, `Code`) VALUES ('".$Hash."', '".$Code."');");
  
  //Output loading presentation
  $ACE='<div class="ace_'.$Hash.' '.$Class.'"';
  if(!($ID=='')){
    $ACE.=' id="'.$ID.'"';
  }
  $ACE.='><img src="/img/ajax-loader.gif"> '.$LoadingMessage.'</div><script>$.get("/ace/'.$Hash.'",function(data){$(".ace_'.$Hash.'").html(data);});</script>';
  echo $ACE;
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
    $Code=base64_decode($Code[0]['Code']);
    eval($Code);
    exit;
  }
  die('Invalid ACE Hash.');
}


function ACEDatabaseSetup(){
  $SQL="
    CREATE TABLE `ACE` (
      `ACEID` int(11) NOT NULL,
      `Hash` varchar(255) NOT NULL,
      `Code` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    ALTER TABLE `ACE` ADD PRIMARY KEY (`ACEID`), ADD KEY `Hash` (`Hash`(191));
    ALTER TABLE `ACE` MODIFY `ACEID` int(11) NOT NULL AUTO_INCREMENT;
    
 ";
  global $ASTRIA;
  mysqli_multi_query($ASTRIA['databases']['astria']['resource'],$SQL);
}
