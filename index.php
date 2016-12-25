<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!file_exists('config.php')){
  require('setup.php');
  setup();
}

echo '1';

require('config.php');
require('debugging/main.php');
require('events/main.php')
require('loader.php');

echo '2';

Loader('core');
Loader('auth/Google');
Loader('microservices/view');

RequireSSL();

echo '3';

//LoadViews();

Event('Before Checking If User Is Logged In');

if(LoggedIn()){
  
  Event('User Is Logged In - Before Presentation');
  Event('User Is Logged In - Presentation');
  
}else{
  
  Event('User Is Not Logged In');
  PromptForLogin();
  
}
