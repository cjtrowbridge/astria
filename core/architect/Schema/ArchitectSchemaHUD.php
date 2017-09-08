<?php

function ArchitectSchemaHUD(){
  TemplateBootstrap4('Schema HUD','ArchitectSchemaHUDBodyCallback();');
}

function ArchitectSchemaHUDBodyCallback(){
  global $ASTRIA;
  ?><h1>Schema - Architect</h1>
  
  <?php
  echo ArrTabler($ASTRIA['databases']);
  
}
