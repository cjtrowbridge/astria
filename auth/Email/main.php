<?php 

include_once('auth/Email/SignupEmailConfirmation.php');

Hook('Attempt Auth','AttemptEmailAuth();');
function AttemptEmailAuth(){
  include_once('core/Session.php');  
  global $ASTRIA;
  Event('Starting Email Auth Check');
  if(
    (path(0)=='authEmail')&&
    isset($_POST['loginEmail'])
  ){
    include_once('auth/Email/ConfirmEmailUser.php');
    ConfirmEmailUser();
    
  }elseif(isset($_POST['signupEmail'])){
    include_once('auth/Email/SignupEmailUser.php');
    SignupEmailUser($_POST['signupEmail']);
    header('Location: /signupemailconfirmation');
    exit;
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
                <button type="submit" class="btn btn-primary">Log In</button>
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
