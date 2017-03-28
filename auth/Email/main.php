<?php 

include_once('auth/Email/SignupEmailConfirmation.php');

Hook('Attempt Auth','AttemptEmailAuth();');
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

    $Existing = Query("SELECT UserID FROM `User` WHERE Email LIKE '".$Email."'");
    
    if(count($Existing)==0){

      //New User
      Query("
        INSERT INTO `User` 
          (`Email`, `PasswordExpires`, `LoginHash`,`SignupDate`) 
        VALUES 
          ('".$Email."', NOW(), '".$Hash."',NOW())
      ");
      
      $Message="<!DOCTYPE html>
      <h1>".$ASTRIA['app']['appName']."</h1>
      <p><i>Thanks for signing up!</i></p>
      <p>Click on this link or copy and paste it into the address bar in order to complete the signup process!</p>
      <p><a href=\"".$ASTRIA['app']['appURL']."/authEmail?confirmationLink=".urlencode($Hash)."\"></a></p>
      ";
      
      SendEmail(
        $Email,
        $Message
      );
      
      header('Location: /signupemailconfirmation');
      exit;

    }else{
      //TODO check if user has an email password and if not, send link to create one
      //TODO prompt for email password and then handle login
      echo 'blue rabbit';
    }
    exit;
  }elseif(
    (path(0)=='authEmail')&&
    isset($_GET['confirmationLink'])
  ){
    
    //TODO handle confimration link
    
  }
  
}

Hook('Auth Login Options','authEmailCallback();');
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
