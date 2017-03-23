<?php

function SignupEmailUser(){
  
  $Hash  = sha2(uniqid(true));
  $Email = $_POST['signupEmail'];
  
  $Hash  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Hash);
  $Email = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Email);
  
  $Existing = Query("SELECT UserID FROM `User` WHERE Email LIKE '".$Email."'");
  
  if(count($Existing)==0){
  
    //New User
    Query("
      INSERT INTO `User` 
        (`Email`, `PasswordExpires`, `LoginHash`) 
      VALUES 
        ('".$Email."', NOW(), '".$Hash."')
    ");
    
    
  }else{
    
    //Existing User
    Query("UPDATE `User` SET `LoginHash` = '".$Hash."' WHERE `Email` LIKE ".$Existing[0]['Email'].";");
    
    
  }
  
}
