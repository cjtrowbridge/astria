<?php

include_once('Path.php');

Hook('User Is Logged In - Before Presentation','prepareArchitect();');

function prepareArchitect(){
  // TODO Should user be able to see this?
  if(path(0)=='architect'){
    switch(path(1)){
      case 'new-view':
        ArchitectNewView();
        break;
      case 'edit':
        ArchitectEditView();
        break;
      default:
        Hook('User Is Logged In - Presentation','showArchitect();');
        break;
    }
  }
}

