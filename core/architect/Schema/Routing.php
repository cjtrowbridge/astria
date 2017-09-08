<?php

function ArchitectSchema(){
  switch(path(2)){
    
    default:
      include('ArchitectSchemaHUD.php');
      ArchitectSchemaHUD();
      break;
  }
}
