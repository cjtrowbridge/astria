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
    $UserID=null;
  }

  if(
    HasMembership(2)||
    $UserID==1
  ){

    SetupArchitect();

    //global $ASTRIA;
    //$ASTRIA['nav']['main']=array(
      //'Architect' => '/architect'
    //);
    Nav('Main','Link','Architect','/architect');

  }
}

function SetupArchitect(){
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

