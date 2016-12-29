<?php

include_once('Path.php');

if(
  path()=='architect'
  //&& TODO User should be able to see this
){
  Hook('Template Body','ArchitectBodyCallback();');
  TemplateBootstrap2('Architect');
}

function ArchitectBodyCallback(){
  global $EVENTS;
  ?>
<h1>Architect</h1>
<div class="row">
  <div class="col-xs-12 col-md-4">
    <h2>Current Hooks</h2>
    <?php pd($EVENTS); ?>
  </div>
  <div class="col-xs-12 col-md-8">
    <h2>Debug Summary</h2>
    <?php DebugShowSummary(); ?>
  </div>
  </div>
<?php
}
