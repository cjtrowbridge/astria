<?php

if(
  isset($_SESSION['User']['Memberships'][2])&&
  ($_SESSION['User']['Memberships'][2]==2)
){
  include_once('Path.php');
  Hook('User Is Logged In - Before Presentation','prepareArchitect();');
  
  global $ASTRIA;
  $ASTRIA['nav']=array(
    'Architect' => '/architect'
  );
  
}

function prepareArchitect(){
  if(path(0)=='architect'){
    switch(path(1)){
      case 'schema':
        showArchitectSchema();
        break;
      case 'config':
        include('setup.php');
        setup();
        break;
      case 'view-category':
        showArchitectViewCategory();
        break;
      case 'disk-cache':
        showArchitectDiskCache();
        break;
      case 'new-view':
        ArchitectNewView();
        break;
      case 'edit':
      case 'edit-view':
        if(path(3)=='new-hook'){
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

