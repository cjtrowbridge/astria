<?php 

global $ASTRIA;
if(
  isset($ASTRIA['oauth'])&&
  isset($ASTRIA['oauth']['Google'])&&
  isset($ASTRIA['oauth']['Google']['GoogleOAuth2ClientID'])&&
  (!($ASTRIA['oauth']['Google']['GoogleOAuth2ClientID']==''))
){
  Hook('Attempt Auth','AttemptGoogleAuth();');
  Hook('Auth Login Options','authGoogleCallback();');
}else{
  //notify admin about this
  Hook('Architect Homepage','AlertAdminMissingGoogleOAuthCredentials();');
}

function AlertAdminMissingGoogleOAuthCredentials(){
   ?>
    <div class="card">
      <div class="card-block">
        <h4 class="card-title">Missing Google OAuth Configuration</h4>
        <p class="card-text"><a href="/architect/configuration" class="card-link">Click Here</a> to update missing configuration data.</p>
      </div>
    </div>
  <?php
}

Hook('Challenge Session', 'GoogleChallengeSession();');  
function GoogleChallengeSession(){
  include_once('auth/Google/autoload.php');
  global $ASTRIA;
  if(
    isset($ASTRIA['Session'])&&
    isset($ASTRIA['Session']['google_oauth2'])&&
    isset($ASTRIA['Session']['google_oauth2']['access_token'])
  ){
    $Token = $ASTRIA['Session']['google_oauth2']['access_token'];
    $Token = json_decode($Token,true);
    pd($Token);
    echo '<hr>';
    
    $client = new Google_Client();
    $client->setClientId($ASTRIA['oauth']['Google']['GoogleOAuth2ClientID']);
    $client->setClientSecret($ASTRIA['oauth']['Google']['GoogleOAuth2ClientSecret']);
    $client->setRedirectUri($ASTRIA['app']['appURL'].'/authGoogle/');
    $client->addScope("email");
    $client->addScope("profile");
    $client->setAccessType('offline');
    //$client->setDeveloperKey('');
    $client->refreshToken($Token);
    pd($client);
    exit;
  }
}

function AttemptGoogleAuth(){
  include_once('core/Session.php');
  include_once('auth/Google/autoload.php');
  global $ASTRIA;
  Event('Starting Google Auth Check');
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
  $client->setRedirectUri($ASTRIA['app']['appURL'].'/authGoogle/');
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
  if(
    (path(0)=='authgoogle')&&
    isset($_GET['code'])
  ){
    Event('Google Auth Check: User is attempting to log in. Check with google and refresh.');
    $client->authenticate($_GET['code']);
    $ASTRIA['Session']['google_oauth2']=array('access_token' => $client->getAccessToken());
    AstriaSessionSave();
    header('Location: /');
    exit;
  }
  
  /************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
  ************************************************/
  if(isset($ASTRIA['Session']['google_oauth2']) && isset($ASTRIA['Session']['google_oauth2']['access_token']) && $ASTRIA['Session']['google_oauth2']['access_token']){
    Event('Google Auth Check: User just authenticated with google, now lets load all their stuff into the session.');
    $client->setAccessToken($ASTRIA['Session']['google_oauth2']['access_token']);
    $ASTRIA['Session']['google_oauth2']['user_object']=$service->userinfo->get();
    
      MakeSureDBConnected();
      $cleanEmail=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email);
    
      $results=Query("SELECT UserID FROM `User` WHERE `Email` LIKE '".$cleanEmail."' LIMIT 1"); 
      if(count($results)==0){
        
        //SIGNING UP!
        CreateUser($cleanEmail);
        
      }
      $ASTRIA['Session']['Auth']=array(
        'Logged In'		          => true,
        'Last Validated'        => time(),
        'Expires'               => (time()+$ASTRIA['app']['defaultSessionLength']),
        'Already Attempted'     => true
      );
    
    
      //Update User Data From Google
      //TODO make this check if its necessary before updating, in order to save time and resources
      Query("
        UPDATE `User` 
        SET 
          `Photo`     = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->picture)."', 
          `FirstName` = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->givenName)."', 
          `LastName`  = '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->familyName)."' 
        WHERE `Email` LIKE '".mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$ASTRIA['Session']['google_oauth2']['user_object']->email)."';
      ");
    
      AuthenticateUser($ASTRIA['Session']['google_oauth2']['user_object']->email);
    
  }else{
    Event('Google Auth Check: User is not attempting to log in. Creating login key.');
    $authUrl = $client->createAuthUrl();
    $ASTRIA['Session']['google_oauth2']=array('auth_url'=>$authUrl);
    AstriaSessionSave();
  }
  Event('Finished Google Auth Check');
}


function authGoogleCallback(){
  global $ASTRIA, $EVENTS;
  if(count($EVENTS['Attempt Auth'])==1){
  ?>
  <div class="row">
    <div class="col-xs-12">
      <h2>Please Sign In</h2>
    </div>
  </div>
  <?php
  }
  ?>

  <div class="row">
    <div class="col-xs-12">
      <a class="loginButton" href="<?php echo $ASTRIA['Session']['google_oauth2']['auth_url']; ?>"><img src="/img/google-login-button.png" alt="Login with Google" /></a>
    </div>
  </div>

  <?php
}
