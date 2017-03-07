<?php

/*
  Astria Facebook OAuth Integration
  
  
*/

Hook('Attempt Auth','AttemptFacebookAuth();');
function AttemptFacebookAuth(){
  include_once('core/Session.php');
  include_once('auth/Facebook/src/Facebook/autoload.php');
  global $ASTRIA;
  

  $client = new Google_Client();
  $client->setClientId($ASTRIA['oauth']['Facebook']['FacebookOAuth2ClientID']);
  $client->setClientSecret($ASTRIA['oauth']['Facebook']['FacebookOAuth2ClientSecret']);
  $client->setRedirectUri($ASTRIA['app']['appURL']);
  
  if(isset($_GET['code'])){
    $client->authenticate($_GET['code']);
    $ASTRIA['Session']['facebook_oauth2']=array('access_token' => $client->getAccessToken());
    AstriaSessionSave();
    header('Location: /');
    exit;
  }
  
  
  if(isset($ASTRIA['Session']['facebook_oauth2']) && isset($ASTRIA['Session']['facebook_oauth2']['access_token']) && $ASTRIA['Session']['facebook_oauth2']['access_token']){
    $client->setAccessToken($ASTRIA['Session']['facebook_oauth2']['access_token']);
    $ASTRIA['Session']['facebook_oauth2']['user_object']=$service->userinfo->get();
    
      MakeSureDBConnected();
      $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['facebook_oauth2']['user_object']->email);
    
      $results=Query("SELECT UserID FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1"); 
      if(count($results)==0){
        
        //SIGNING UP!
        Query("INSERT INTO `User`(`Email`)VALUES('".$cleanEmail."');");
        //Add this new user to the default group 
        CreateMembership(mysqli_insert_id($ASTRIA['databases']['astria']['resource']),1);
        
        
      }
      $ASTRIA['Session']['Auth']=array(
        'Logged In'		          => true,
        'Last Validated'        => time(),
        'Expires'               => (time()+$ASTRIA['app']['defaultSessionLength']),
        'Already Attempted'     => true
      );
    
    
      //Update User Data From Facebook
      //TODO make this check if its necessary before updating, in order to save time and resources
      Query("
        UPDATE `User` 
        SET 
          `Photo`     = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['facebook_oauth2']['user_object']->picture)."', 
          `FirstName` = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['facebook_oauth2']['user_object']->givenName)."', 
          `LastName`  = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['facebook_oauth2']['user_object']->familyName)."' 
        WHERE `Email` LIKE '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['facebook_oauth2']['user_object']->email)."';
      ");
    
      AuthenticateUser($ASTRIA['Session']['facebook_oauth2']['user_object']->email);
    
  }else{
    $authUrl = $client->createAuthUrl();
    $ASTRIA['Session']['facebook_oauth2']=array('auth_url'=>$authUrl);
    AstriaSessionSave();
  }
  
}
Hook('Auth Login Options','authFacebookCallback();');
function authFacebookCallback(){
  global $ASTRIA;
  ?>
    <p><a class="login" href="<?php echo $ASTRIA['Session']['facebook_oauth2']['auth_url']; ?>"><img src="/img/google-login-button.png" alt="Login with Facebook" /></a></p>
  <?php
}
