<?php

include_once('Path.php');

Hook('User Is Logged In - Before Presentation','prepareArchitect();');

function prepareArchitect(){
  if(
    path()=='architect'
    //&& TODO Should user be able to see this?
  ){
    
    Hook('User Is Logged In - Presentation','showArchitect();');
    
  }
}

function showArchitect(){
  Hook('Template Body','ArchitectBodyCallback();');
  TemplateBootstrap2('Architect'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS;
  ?>
<h1>Architect</h1>
<div class="row">
  <div class="col-xs-12 col-md-5">
    <h2>Current Hooks</h2>
    <?php pd($EVENTS); ?>
  </div>
  <div class="col-xs-12 col-md-7">
    <h2>Debug Summary</h2>
    <?php DebugShowSummary(); ?>
  </div>
  </div>
<?php
}
