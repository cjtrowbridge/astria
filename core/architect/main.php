<?php

include_once('Show.php');

global $ASTRIA;
if(isset($ASTRIA['Session'])){
  if(isset($ASTRIA['Session']['User'])){
    if(isset($ASTRIA['Session']['User']['Memberships'])){ //TODO abstract this better
      if(isset($ASTRIA['Session']['User']['Memberships'][2])){
        if(($ASTRIA['Session']['User']['Memberships'][2]==2)){
          
          Hook('User Is Logged In - Before Presentation','prepareArchitect();');

          $ASTRIA['nav']['main']=array(
            'Architect' => '/architect'
          );
        }
      }
    }
  }
}
  

function prepareArchitect(){
  if(path(0)=='architect'){
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
      case 'config':
        Setup();
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

