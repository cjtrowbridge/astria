<?php

function ArchitectSchema(){
  
  switch(path(2)){
    case false:
      include_once('ArchitectSchemaHUD.php');
      ArchitectSchemaHUD();
      break;
    default:
      //try elaborating on this as a database alias
      include_once('ArchitectSchemaElaborate.php');
      ArchitectSchemaElaborate(path(2));
      break;
  }
}
