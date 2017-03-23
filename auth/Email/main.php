<?php 

include_once('auth/Email/SignupEmailConfirmation.php');

Hook('Attempt Auth','AttemptEmailAuth();');
function AttemptEmailAuth(){
  include_once('core/Session.php');  
  global $ASTRIA;
  Event('Starting Email Auth Check');
  if(
    (path(0)=='authEmail')&&
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
          (`Email`, `PasswordExpires`, `LoginHash`) 
        VALUES 
          ('".$Email."', NOW(), '".$Hash."')
      ");
      //TODO send email with confirmation link

    }else{
      //TODO check if user has an email password and if not, send link to create one
      //TODO prompt for email password and then handle login

    }
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
          <form action="/authEmail" method="post">
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
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
