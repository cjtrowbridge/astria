<?php

if(
  isset($ASTRIA['Session']['User']['Memberships'][2])&&
  ($ASTRIA['Session']['User']['Memberships'][2]==2)
){
  include_once('Path.php');
  Hook('User Is Logged In - Before Presentation','prepareArchitect();');
  
  global $ASTRIA;
  $ASTRIA['nav']=array(
    'Architect' => '/architect'
  );
  
}else{
  include('pd.php');
  pd($ASTRIA['Session']['User']['Memberships']);
  exit;
}

function prepareArchitect(){
  if(path(0)=='architect'){
    switch(path(1)){
      case 'schema':
        if(path(2)=='new'){
          handleArchitectSchemaNew();
        }else{
          showArchitectSchema();
        }
        break;
      case 'edit-hook':
        showEditHook();
        break;
      case 'config':
        include('core/Setup.php');
        Setup();
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

