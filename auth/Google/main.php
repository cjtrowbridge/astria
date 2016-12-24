<?php 


Hook('Attempt Auth','AttemptGoogleAuth();');
function AttemptGoogleAuth(){
  include('auth/Google/autoload.php');
  
  /************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
  ************************************************/
  $client = new Google_Client();
  $client->setClientId(GoogleOAuth2ClientID);
  $client->setClientSecret(GoogleOAuth2ClientSecret);
  $client->setRedirectUri(APPURL);
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
    header('Location: ./');
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
      $results=Query("SELECT UserID FROM `User` WHERE `Email` LIKE '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->email)."' LIMIT 1"); 
      if(count($results)==0){
        
        //SIGNING UP!
        $sql="INSERT INTO `User`(`Email`)VALUES('".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->email)."');";
        Query($sql);
        
        //$results=Query("SELECT UserID,Email,FirstName,LastName,Photo FROM `User` WHERE `Email` LIKE '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->email)."' LIMIT 1"); 
        
      }
      $_SESSION['Auth']=array(
        'Logged In'		          => true,
        'Last Validated'        => time(),
        'Expires'               => (time()+DEFAULTSESSIONLENGTH)
      );
      //$_SESSION['User']=$results[0];
    
    
      //Update user data
      Query("
        UPDATE `User` 
        SET 
          `Photo`     = '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->picture)."', 
          `FirstName` = '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->givenName)."', 
          `LastName`  = '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->familyName)."' 
        WHERE `Email` LIKE '".mysql_real_escape_string($_SESSION['google_oauth2']['user_object']->email)."';
      ");
    
      CacheUserToSession($_SESSION['google_oauth2']['user_object']->email);
    
  }else{
    $authUrl = $client->createAuthUrl();
    $_SESSION['google_oauth2']=array('auth_url'=>$authUrl);
    
  }
  
}

Hook('Auth Login Options','authGoogleCallback();');
function authGoogleCallback(){
  ?>
    <p><a class="login" href="<?php echo $_SESSION['google_oauth2']['auth_url']; ?>"><img src="img/google-login-button.png" /></a></p>
  <?php
}
