<?php

include_once('Path.php');

Hook('User Is Logged In - Before Presentation','prepareArchitect();');

function prepareArchitect(){
  // TODO Should user be able to see this?
  if(path(0)=='architect'){
    switch(path(1)){
      case 'view-category':
        showArchitectViewCategory();
        break;
      case 'new-view':
        ArchitectNewView();
        break;
      case 'edit':
      case 'edit-view':
        if(
          isset(path(3))=='' &&
          path(3)=='new-hook'
        ){
          ArchitectEditViewNewHook();
        }else{
          ArchitectEditView();
        }
        break;
      default:
        Hook('User Is Logged In - Presentation','showArchitect();');
        break;
    }
  }
}

