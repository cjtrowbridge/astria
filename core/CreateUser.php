<?php

function CreateUser($Email){
  global $ASTRIA;
  MakeSureDBConnected();
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email);
  
  //Add user to users table
  Query("INSERT INTO `User`(`Email`,`SignupDate`)VALUES('".$cleanEmail."',NOW());");
  
  //Add this new user to the default group 
  CreateMembership(mysqli_insert_id($ASTRIA['databases']['astria']['resource']),1);
  
  //Notify Admin of signup
  $message = '<h1>'.$ASTRIA['app']['appName'].': New User Signup!</h1><p>'.htmlentities($cleanEmail).'</p>';
  $subject = $ASTRIA['app']['appName'].': New Signup';
  $to      = $ASTRIA['smtp']['adminEmail'];
  if($to==''){
    $to='root@localhost';
  }
  SendEmail($message, $subject, $to);
}
