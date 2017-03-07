<?php

/*
  Astria Facebook OAuth Integration
  
  
*/

Hook('Attempt Auth','AttemptFacebookAuth();');
function AttemptFacebookAuth(){
  include_once('core/Session.php');
  include_once('auth/Facebook/src/Facebook/autoload.php');
  global $ASTRIA,$fb;
  
  //$client->setRedirectUri($ASTRIA['app']['appURL']);
  
  $fb = new Facebook\Facebook([
    'app_id' => $ASTRIA['oauth']['Facebook']['FacebookOAuth2AppID'],
    'app_secret' => $ASTRIA['oauth']['Facebook']['FacebookOAuth2AppSecret'],
    'default_graph_version' => 'v2.2',
  ]);
  
  if(path(0)=='facebookAuth'){

    $helper = $fb->getRedirectLoginHelper();

    try {
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

    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }

    // Logged in
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);

    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId($ASTRIA['oauth']['Facebook']['FacebookOAuth2AppID']); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();


    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
    }

    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
      
  }
  
  $_SESSION['fb_access_token'] = (string) $accessToken;
  
  //Try getting the user's info
  
  try {
    // Get the Facebook\GraphNodes\GraphUser object for the current user.
    // If you provided a 'default_access_token', the '{access-token}' is optional.
    $response = $fb->get('/me', $accessToken);
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
  
  }
  
  //make a login link
  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('https://astria.io/facebookAuth', $permissions);

  $ASTRIA['Session']['facebook_oauth2']['auth_url']=htmlspecialchars($loginUrl);
  

/*
  
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
  */
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
    <p><a class="loginButton" href="<?php echo $authURL; ?>"><img src="/img/facebook-login-button.png" alt="Login with Facebook" /></a></p>
  <?php
}
