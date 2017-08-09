<?php

Hook('User Is Logged In - Before Presentation','PrepareArchitect();');

function PrepareArchitect(){
  global $ASTRIA;
  if(
    isset($ASTRIA['Session'])&&
    isset($ASTRIA['Session']['User'])
  ){
    $UserID = $ASTRIA['Session']['User']['UserID'];
  }else{
    $UserID = null;
  }

  if(
    HasMembership(2)||
    $UserID==1
  ){

    //SetupArchitect();

    //global $ASTRIA;
    //$ASTRIA['nav']['main']=array(
      //'Architect' => '/architect'
    //);
    
    Nav('Main','Link','Architect','/architect');
    Hook('User Is Logged In - Presentation','PresentArchitect();');
  }
}

function PresentArchitect(){
  if(path(0)=='architect'){
    
    include_once('ArchitectShow.php');
    switch(path(1)){
      case 'create-webhook-pull-subrepository':
        include_once('GetSubrepositoryPullWebhook.php');
        GetSubrepositoryPullWebhook();
      case 'files':
        switch(path(2)){
          case 'edit':
            include_once('core/architect/Files/ArchitectFileEditor.php');
            ArchitectFileEditor();
            break;
          case 'new': //TODO
          case 'delete': //TODO
          case 'create-file': //TODO
          case 'create-directory': //TODO
          case 'upload': //TODO  
            
          default:
            include_once('core/architect/Files/ArchitectFileExplorer.php');
            ArchitectFileExplorer();
            break;
        }
        break;
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
        AstriaConfiguration();
        break;
      case 'cache':
        switch(path(2)){
          case 'manage': //TODO
        }
        break;
      default:
        showArchitect();
        break;
    }
  }
}

