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
        break;
      case 'plugins':
        include_once('ArchitectPluginManager.php');
        ArchitectPluginManager();
        break;
      case 'feedsync':
        include_once('FeedSyncUI/main.php');
        FeedSyncUI();
        break;
      case 'df':
        include_once('ArchitectDF.php');
        ArchitectDF();
        break;
      case 'ifconfig':
        include_once('ArchitectIfconfig.php');
        ArchitectIfconfig();
        break;
      case 'top':
        include_once('ArchitectTop.php');
        ArchitectTop();
        break;
      case 'schema':
        include_once('Schema/Routing.php');
        ArchitectSchema();
        break;
      case 'files':
        switch(path(2)){
          case 'upload':
            include_once('core/architect/Files/ArchitectFileUpload.php');
            ArchitectFileUpload();
            break;
          case 'copy-remote':
            include_once('core/architect/Files/ArchitectFileCopyRemote.php');
            ArchitectFileCopyRemote();
            break;
          case 'create-file':
            include_once('core/architect/Files/ArchitectFileCreate.php');
            ArchitectFileCreate();
            break;
          case 'edit':
            include_once('core/architect/Files/ArchitectFileEditor.php');
            ArchitectFileEditor();
            break;
          case 'delete':
            include_once('core/architect/Files/ArchitectFileDelete.php');
            ArchitectFileDelete();
            break;
          case 'create-directory':
            include_once('core/architect/Files/ArchitectDirectoryCreate.php');
            ArchitectDirectoryCreate();
            break;
          case 'delete-directory':
            include_once('core/architect/Files/ArchitectDirectoryDelete.php');
            ArchitectDirectoryDelete();
            break;
          
          case 'move':
            include_once('core/architect/Files/ArchitectFileMove.php');
            ArchitectFileMove();
            break;
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

