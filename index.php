<?php

if(file_exists('config.php')){
  require('config.php');
}else{
  //TODO
  die('Please create a config file.');
}

include('events.php');
include('loader.php');

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
