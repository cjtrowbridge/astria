<?php

function AuthenticateUser($email=null){
  global $ASTRIA;
  
  //Validate and sanitize the email
  if($email == null){die('Tried to authenticate invalid user.');}
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email);
  
  //Get all the user's profile info for the session
  $User=Query("SELECT UserID,Email,FirstName,LastName,Photo FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1")[0]; 
  $ASTRIA['Session']['User']=$User;
  
  //Insert group memberships into the session
  $ASTRIA['Session']['User']['Memberships']=GetAllGroups($ASTRIA['Session']['User']['UserID']);
  
  //Insert user into database session
  $UserIDClean         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$User['UserID']);
  
  $SQL="
    UPDATE `Session` SET `UserID` = '".$UserIDClean."' WHERE `Session`.`SessionHash` LIKE '".$ASTRIA['Session']['SessionHash']."';
  ";
  pd($SQL);
  Query($SQL);
  
  //Cache the entire session
  AstriaSessionSave();
  
  //header('Location: /');
  exit;
}
