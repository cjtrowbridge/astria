<?php

function ArchitectSchemaElaborate(){
  global $ASTRIA;
  if(!(isset($ASTRIA['databases'][path(2)]))){
    die('Invalid Database Alias');
  }
  
  TempalteBootstrap4('SChema: '.path(2),'ArchitectSchemaElaborateBodyCallback();');
}


function ArchitectSchemaElaborateBodyCallback(){
  global $ASTRIA;
  $ASTRIA['databases'][path(2)]
  
  pd($ASTRIA['databases'][path(2)]);
  
}
