<?php

if(HasMembership(2)){
  
  Hook('User Is Logged In - Before Presentation','prepareArchitect();');
  
  global $ASTRIA;
  $ASTRIA['nav']['main']=array(
    'Architect' => '/architect'
  );
  
}
  

function prepareArchitect(){
  if(path(0)=='architect'){
    include_once('ArchitectShow.php');
    switch(path(1)){
      case 'user':
        switch(path(2)){
          case 'edit': //TODO
          case 'new': //TODO
        }
        break;
      case 'schema':
        switch(path(2)){
          case 'edit': //TODO
          case 'new': //TODO
        }
        break;
      case 'configuration':
        echo 'WHY';
        AstriaConfiguration();
        break;
      case 'cache':
        switch(path(2)){
          case 'manage': //TODO
        }
        break;
      default:
        Hook('User Is Logged In - Presentation','showArchitect();');
        break;
    }
  }
}

