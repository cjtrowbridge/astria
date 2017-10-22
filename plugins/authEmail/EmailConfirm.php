<?php

Hook('User Is Not Logged In','EmailConfirm();');
function EmailConfirm(){
  if(path(0)=='emailconfirm'){
    if(isset($_POST['hash'])){
      
      //TODO these could be more elegant
      if(!($_POST['password1']==$_POST['password2'])){
        die('Passwords do not match!');
      }
      if(strlen($_POST['password1'])<8){
        die('Password must be at least 8 characters!');
      }
      
      $Password = sha512($_POST['password1']);
      $Password  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$Password);
      
      Query("
        UPDATE `User` 
          SET 
          `LastLogin` = NOW(),
          `Password` = '".$Password."',
          `EmailConfirmationHash` = null,
          `PasswordExpires` = null
          WHERE Email LIKE '".$Email."'
      ");
      
      header('Location: /');
      exit;
      
    }
    
    Hook('Template Body','EmailConfirmedBodyCallback();');
    TemplateBootstrap4('Thanks for Confirming Your Email!');
  }
}
function EmailConfirmedBodyCallback(){
  ?>
  
  <h1>Your Email Has Been Confirmed!</h1>
  <p>Time to create a password. Make sure it is at least 8 characters!</p>
  <div class="container">
    <div class="row">
      <form action="/emailconfirmed" method="post" class="form">
        <input type="hidden" name="hash" value="<?php echo $_GET['hash']; ?>">
        <div class="form-group col-xs-12">
          <input type="password" class="form-control" id="password1" name="password1" placeholder="Enter A Password">
        </div>
        <div class="form-group col-xs-12">
          <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password">
        </div>
        <div class="form-group col-xs-12">
          <button type="submit" class="form-control btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
  
  <?php
}
