<?php

function CreateUser($Email){
  global $ASTRIA;
  MakeSureDBConnected();
  $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email);
  
  //Add user to users table
  Query("INSERT INTO `User`(`Email`,`SignupDate`)VALUES('".$cleanEmail."',NOW());");
  
  $User = Query("SELECT UserID FROM User WHERE Email LIKE '".$cleanEmail."';");
  if($User[0]['UserID']==1){
    Query("UPDATE User SET IsAstriaAdmin = TRUE, IsWaiting = FALSE WHERE Email LIKE '".$cleanEmail."';");
  }
  
  //TODO make this into some kind of service that admins can add code to
  //Add this new user to the default group 
  //CreateMembership(mysqli_insert_id($ASTRIA['databases']['astria']['resource']),1);
  
  //Notify Admin of signup
  $message = '<h1>'.$ASTRIA['app']['appName'].': New User Signup!</h1><p>'.htmlentities($cleanEmail).'</p>';
  $subject = $ASTRIA['app']['appName'].': New Signup';
  $to      = $ASTRIA['smtp']['adminEmail'];
  if($to==''){
    $to='root@localhost';
  }
  SendEmail($message, $subject, $to);
}
