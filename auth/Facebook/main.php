<?php

/*
  Astria Facebook OAuth Integration
  
  Astria does not use PHP sessions because they are less scalable and fault-tolerant than Astria's hybrid cached sessions, but Facebook's SDK needs them. 
  These first two functions allow Facebook's session data to propagate across scaled infrastructure so that it works with load balancers.
*/

Hook('Before Auth','BeforeAuthFacebook();');
function BeforeAuthFacebook(){
  session_start();
  global $ASTRIA;
  if(isset($ASTRIA['Session']['FBRLH_state'])){
    ResetFBRLHState();
  }
}
function ResetFBRLHState(){
  global $ASTRIA;
  $_SESSION['FBRLH_state']=$ASTRIA['Session']['FBRLH_state'];
}
Hook('After Auth','AfterAuthFacebook();');
function AfterAuthFacebook(){
  global $ASTRIA;
  if(isset($_SESSION['FBRLH_state'])){
    $ASTRIA['Session']['FBRLH_state']=$_SESSION['FBRLH_state'];
    AstriaSessionSave();
  }
}

Hook('Attempt Auth','AttemptFacebookAuth();');
function AttemptFacebookAuth(){
  pd(session_id());
  Event('Beginning Facebook Auth Check');
  include_once('core/Session.php');
  include_once('auth/Facebook/src/Facebook/autoload.php');
  global $ASTRIA,$fb;
  
  
  $Parameters=array(
    'app_id' => $ASTRIA['oauth']['Facebook']['FacebookOAuth2AppID'],
    'app_secret' => $ASTRIA['oauth']['Facebook']['FacebookOAuth2AppSecret'],
    'default_graph_version' => 'v2.2'
  );
  
  $fb = new Facebook\Facebook($Parameters);
  
  if(path(0)=='authfacebook'){
    Event('Facebook Auth Check: User is attempting to log in. Validate with facebook and refresh.');
    pd($_SESSION);
    try {
      ResetFBRLHState();
      $helper = $fb->getRedirectLoginHelper();
      //pd($_SESSION);
      //pd($_GET);
      ResetFBRLHState();
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (isset($accessToken)) {
      // Logged in!
      $_SESSION['facebook_access_token'] = (string) $accessToken;

      // Now you can redirect to another page and use the
      // access token from $_SESSION['facebook_access_token']
      pd($accessToken);
      exit;
    }

    
    
    
    
    try {
      // Get the Facebook\GraphNodes\GraphUser object for the current user.
      // If you provided a 'default_access_token', the '{access-token}' is optional.
      $response = $fb->get('/me', $_GET['code']);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $me = $response->getGraphUser();
    echo 'Logged in as ' . $me->getName();
    pd($me);
    exit;
  
 
  
  /*
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
    */
  }else{
    Event('Facebook Auth Check: User is not attempting to log in. Create a login link.');
    //make a login link for facebook
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email']; // Optional permissions
    ResetFBRLHState();
    $loginUrl = $helper->getLoginUrl($ASTRIA['app']['appURL'].'/authFacebook/', $permissions);
    ResetFBRLHState();
    $ASTRIA['Session']['facebook_oauth2']['auth_url']=htmlspecialchars($loginUrl);
    AstriaSessionSave();
  }
  
  Event('Finished Facebook Auth Check');
}
Hook('Auth Login Options','authFacebookCallback();');
function authFacebookCallback(){
  global $ASTRIA;
  
  $authURL ='';
  
  if(isset($ASTRIA['Session'])){
    if(isset($ASTRIA['Session']['facebook_oauth2'])){
      if(isset($ASTRIA['Session']['facebook_oauth2']['auth_url'])){
        $authURL = $ASTRIA['Session']['facebook_oauth2']['auth_url'];
      }
    }
  }
  
  ?>

  <div class="row">
    <div class="col-xs-12">
      <a class="loginButton" href="<?php echo $authURL; ?>"><img src="/img/facebook-login-button.png" alt="Login with Facebook" /></a>
    </div>
  </div>

  <?php
  pd($_SESSION);
}
