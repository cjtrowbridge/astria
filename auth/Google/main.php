<?php 


Hook('Attempt Auth','AttemptGoogleAuth();');
function AttemptGoogleAuth(){
  include_once('auth/Google/autoload.php');
  global $ASTRIA;
  
  /************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
  ************************************************/
  $client = new Google_Client();
  $client->setClientId($ASTRIA['oauth']['Google']['GoogleOAuth2ClientID']);
  $client->setClientSecret($ASTRIA['oauth']['Google']['GoogleOAuth2ClientSecret']);
  $client->setRedirectUri($ASTRIA['app']['appURL']);
  $client->addScope("email");
  $client->addScope("profile");
  
  /************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
  ************************************************/
  $service = new Google_Service_Oauth2($client);
  
  /************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself. */
  if(isset($_GET['code'])){
    $client->authenticate($_GET['code']);
    $_SESSION['google_oauth2']=array('access_token' => $client->getAccessToken());
    header('Location: /');
    exit;
  }
  
  /************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
  ************************************************/
  if(isset($_SESSION['google_oauth2']) && isset($_SESSION['google_oauth2']['access_token']) && $_SESSION['google_oauth2']['access_token']){
    $client->setAccessToken($_SESSION['google_oauth2']['access_token']);
    $_SESSION['google_oauth2']['user_object']=$service->userinfo->get();
    
      MakeSureDBConnected();
      $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SESSION['google_oauth2']['user_object']->email);
    
      $results=Query("SELECT UserID FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1"); 
      if(count($results)==0){
        
        //SIGNING UP!
        Query("INSERT INTO `User`(`Email`)VALUES('".$cleanEmail."');");
        //Add this new user to the default group 
        CreateMembership(mysqli_insert_id($ASTRIA['databases']['astria']['resource']),1);
        
        
      }
      $_SESSION['Auth']=array(
        'Logged In'		          => true,
        'Last Validated'        => time(),
        'Expires'               => (time()+$ASTRIA['app']['defaultSessionLength'])
      );
    
    
      //Update User Data From Google
      //TODO make this check if its necessary before updating, in order to save time and resources
      Query("
        UPDATE `User` 
        SET 
          `Photo`     = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SESSION['google_oauth2']['user_object']->picture)."', 
          `FirstName` = '".mysqli_real_escape_string($ASTRIA['databases']['astri']['resource'],$_SESSION['google_oauth2']['user_object']->givenName)."', 
          `LastName`  = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SESSION['google_oauth2']['user_object']->familyName)."' 
        WHERE `Email` LIKE '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_SESSION['google_oauth2']['user_object']->email)."';
      ");
    
      AuthenticateUser($_SESSION['google_oauth2']['user_object']->email);
    
  }else{
    $authUrl = $client->createAuthUrl();
    $_SESSION['google_oauth2']=array('auth_url'=>$authUrl);
    
  }
  
}

Hook('Auth Login Options','authGoogleCallback();');
function authGoogleCallback(){
  ?>
    <p><a class="login" href="<?php echo $_SESSION['google_oauth2']['auth_url']; ?>"><img src="/img/google-login-button.png" alt="Login with Google" /></a></p>
  <?php
}
