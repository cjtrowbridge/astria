<?php
$_GET['verbose']='verbose';
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!file_exists('config.php')){
  include('core/Configuration.php');
  AstriaConfiguration();
}
include('config.php');

if(file_exists('schema.php')){
  include('schema.php');
}

include('core/Locale.php');
include('core/Loader.php');
Loader('core');

RequireSSL();

Event('Webhook');

//Loading plugins should happen after the webhooks so that if there is an integration error, it will not break the webhooks.
LoadPlugins();

Event('Before Login');

if(LoggedIn()){
  
  if(IsWaiting()){
    AstriaWaitingRoom();
  }
  
  //This is the first event after a user is logged in. Views will be hooked here, as well as anything that should happen at that point.
  Event('User Is Logged In');
  
  //This is where we build any user-facing elements for the presentation and where we do anything that interrupts normal presentation.
  Event('User Is Logged In - Before Presentation');
  
  //This should really only be used for hooking the template which will display the page.
  Event('User Is Logged In - Presentation');
  
  //This should not typically be necessary but it will display a 404 page if no template or other interrupts have occured.
  Event('User Is Logged In - No Presentation');
  
  DefaultViewNoView();
  
}else{
  
  Event('User Is Not Logged In');
  Event('User Is Not Logged In - Before Presentation');
  Event('User Is Not Logged In - Presentation');
  Event('User Is Not Logged In - No Presentation');
  
  PromptForLogin();
  
}
