<?php

function AuthenticateUser($email=null){
  Event('User has been authenticated. Loading User Data...');
  global $ASTRIA;
  
  //Make sure the tables are set up the new way
  if(TableExists('Group')){
    Query("ALTER TABLE `Group` RENAME `UserGroup`;");
  }
  if(TableExists('UserMembership')){
    Query("ALTER TABLE `UserMembership` RENAME `UserGroupMembership`;");
  }
  
  //Validate and sanitize the email
  if($email == null){die('Tried to authenticate invalid user.');}
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email);
  
  //Get all the user's profile info for the session
  $User=Query("SELECT *,NULL as Password FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1")[0]; 
  $ASTRIA['Session']['User']=$User;
  
  //Insert group memberships into the session
  $ASTRIA['Session']['User']['Memberships']=GetAllGroups($ASTRIA['Session']['User']['UserID']);
  
  //Insert user into database session
  $UserIDClean         = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$User['UserID']);
  Query("UPDATE `Session` SET `UserID` = '".$UserIDClean."' WHERE `Session`.`SessionHash` LIKE '".$ASTRIA['Session']['SessionHash']."';");
  
  Query("UPDATE `User` SET `LastLogin` = NOW() WHERE `UserID` = ".$UserIDClean.";");
  
  //Get all the user's permissions
  LoadUserPermissionsIntoSession();
  
  //Let any other session set up happen
  Event('Set Up Session');
  
  //Cache the entire session
  AstriaSessionSave();
  
  pd(strtolower(md5($ASTRIA['app']['appURL'])));
  
  header('Location: /');
  exit;
}
