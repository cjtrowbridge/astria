<?php 

//TODO

global $ASTRIA;
if(
  isset($ASTRIA['smtp'])&&
  isset($ASTRIA['smtp']['host'])&&
  (!($ASTRIA['smtp']['host']==''))
){
  include_once('auth/Email/SignupEmailConfirmation.php');
  include_once('auth/Email/EmailNotConfirmed.php');
  include_once('auth/Email/EmailConfirm.php');

  Hook('Attempt Auth','AttemptEmailAuth();');
  Hook('Auth Login Options','authEmailCallback();');

}else{
  //TODO notify admin about this(?)
}


function AttemptEmailAuth(){
  include_once('core/Session.php');  
  global $ASTRIA;
  Event('Starting Email Auth Check');
  if(
    (path(0)=='authemail')&&
    isset($_POST['email'])
  ){
    $Hash  = sha512(uniqid(true));
    $Email = $_POST['email'];

    $Hash  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Hash);
    $Email = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Email);

    $Existing = Query("SELECT * FROM `User` WHERE Email LIKE '".$Email."'");
    
    if(count($Existing)==0){

      //New User
      Query("
        INSERT INTO `User` 
          (`Email`, `PasswordExpires`, `EmailConfirmationHash`,`SignupDate`) 
        VALUES 
          ('".$Email."', NOW(), '".$Hash."',NOW())
      ");
      
      SendConfirmationEmail(array('Email'=>$Email));
      
      header('Location: /signupemailconfirmation');
      exit;

    }else{
      if($Existing[0]['Password']==''){
        $Hash  = sha512(uniqid(true));
        $Email = $_POST['email'];

        $Hash  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Hash);
        $Email = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Email);
        Query("
          UPDATE `User` 
            SET 
            `PasswordExpires` = NOW(),
            `EmailConfirmationHash` = '".$Hash."'
            WHERE Email LIKE '".$Email."'
        ");
      }
      if(!($Existing[0]['EmailConfirmationHash']=='')){
        SendConfirmationEmail($Existing[0]);
        header('Location: /emailnotconfirmed');
        exit;
      }
    }
    exit;
  }elseif(
    (path(0)=='authemail')&&
    isset($_GET['confirmationLink'])
  ){
    
    header('Location: /emailconfirm?hash='.urlencode($_GET['confirmationLink']));
    exit;
    
  }
  
}


function authEmailCallback(){
  global $ASTRIA;
  ?>
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h4>Log In Or Sign Up By Email</h4>
        <div class="container">
          <form action="/authEmail" method="post" class="form-inline">
            <div class="form-group">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <button type="submit" class="form-control btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
      
      
      <?php
        global $EVENTS;
        if(count($EVENTS['Attempt Auth'])>1){
      ?>
      
      <div class="col-xs-12">
        <h4>Or Use Another Account</h4>
      </div>
      
      <?php } ?>
      
    </div>
    
  <?php
}

function SendConfirmationEmail($User){
  global $ASTRIA;
  $Message="<!DOCTYPE html>
  <h1>".$ASTRIA['app']['appName']."</h1>
  <p><i>Thanks for signing up!</i></p>
  <p>Click on this link or copy and paste it into the address bar in order to complete the signup process!</p>
  <p><a href=\"".$ASTRIA['app']['appURL']."/emailconfirm?hash=".urlencode($User['EmailConfirmationHash'])."\">".$ASTRIA['app']['appURL']."/authEmail?confirmationLink=".urlencode($User['EmailConfirmationHash'])."</a></p>
  ";

  SendEmail(
    $Message, 
    'Welcome to '.$ASTRIA['app']['appName'], 
    $User['Email']
  );
}
