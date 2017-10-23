<?php


function ArchitectMyPermissions(){
  TemplateBootstrap4('My Permissions - Architect' , 'ArchitectMyPermissionsBodyCallback();');
}
function ArchitectMyPermissionsBodyCallback(){
  global $ASTRIA;
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/my-permissions">My Permissions</a></h1>
  
  <?php pd($ASTRIA['Session']['User']['Permission']); ?>
    
  <?php
}
