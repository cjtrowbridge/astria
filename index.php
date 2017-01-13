<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!file_exists('config.php')){
  include('setup.php');
  setup();
}

include('config.php');
session_start();

include('events/main.php');
include('loader.php');

Loader('core');
Loader('auth/Google');
Loader('view');

RequireSSL();

//Some callbacks do not require a user to be logged in, primarily webhooks and public-facing pages. Those will be hooked here.
Event('Before Checking If User Is Logged In');

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
