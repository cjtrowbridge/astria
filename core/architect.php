<?php

include_once('Path.php');

if(
  path()=='architect'
  //&& TODO User should be able to see this
){
  Hook('Template Body','ArchitectBodyCallback();');
}

function ArchitectBodyCallback(){
  global $EVENTS;
  ?>
<h1>Architect</h1>
<div class="col-xs-12 xol-md-6">
  <h2>Current Hooks</h2>
  <?php pd($EVENTS); ?>
</div>
<div class="col-xs-12 xol-md-6">
  <h2>Debug Summary</h2>
  <?php DebugShowSummary(); ?>
</div>
<?php
}
