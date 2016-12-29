<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!file_exists('config.php')){
  require('setup.php');
  setup();
}

include('config.php');
include('events/main.php');
include('loader.php');

Loader('core');
Loader('auth/Google');
Loader('architect');
Loader('view');

RequireSSL();

//LoadViews();

Event('Before Checking If User Is Logged In');

if(LoggedIn()){
  
  Event('User Is Logged In - Before Presentation');
  Event('User Is Logged In - Presentation');
  Event('User Is Logged In - No Presentation');
  
}else{
  
  Event('User Is Not Logged In');
  PromptForLogin();
  
}
