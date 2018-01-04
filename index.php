<?php
/*
TODO
make feedsync be able to create schema based on feeds
build astria team manager
create a persistent verbosity option with some sort of agent/ip check
abstract the astria complex variable caching feature into a core function. move the session things into that
make plugins not load all subdirectories recursively automatically. Instead, just the main routing file.
update database script with the self-referential foreign key for usergroup parent, and add a patch.
make foreign keys for usergroupmembership table
Set a minimum session challenge interval
make the plugins be downloadable
make a patch to update collation to utf8mb4
*/

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
    Event('Astria Waiting Room');
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
