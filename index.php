<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
echo 'wtf';
if(!file_exists('config.php')){
  include('core/Setup.php');
  Setup();
}
echo 'the first rabbit ';
include('config.php');
include('core/Loader.php');
//session_start();
echo 'white rabbit ';
Loader('core');
echo 'blue rabbit ';
Loader('auth/Google');
echo 'red rabbit ';
RequireSSL();

if(LoggedIn()){
  
  //This is the first event after a user is logged in. Views will be hooked here, as well as anything that should happen at that point.
  Event('User Is Logged In');
  
  //This is where we build any user-facing elements for the presentation and where we do anything that interrupts normal presentation.
  Event('User Is Logged In - Before Presentation');
  
  //This should really only be used for hooking the template which will display the page.
  Event('User Is Logged In - Presentation');
  
  //This should not typically be necessary but it will display a 404 page if no template or other interrupts have occured.
  Event('User Is Logged In - No Presentation');
  
}else{
  
  Event('User Is Not Logged In');
  PromptForLogin();
  
}
