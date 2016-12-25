<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(file_exists('config.php')){
  
  require('config.php');
  
}else{
  
  require('setup.php');
  setup();
  
}

require('loader.php');

Loader('events');
Loader('debugging');
Loader('core');
Loader('auth/Google');
Loader('microservices/view');

RequireSSL();

LoadViews();

Event('Before Checking If User Is Logged In');

if(LoggedIn()){
  
  Event('User Is Logged In - Before Presentation');
  Event('User Is Logged In - Presentation');
  
}else{
  
  Event('User Is Not Logged In');
  PromptForLogin();
  
}
