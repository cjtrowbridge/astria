<?php

function ArchitectSession(){
  TemplateBootstrap4('Session - Architect','ArchitectSessionBodyCallback();'); 
}
function ArchitectSessionBodyCallback(){
  global $ASTRIA;
  ?>
  
  <h1>Session</h1>
  pd($ASTRIA['Session']);
  
  <?php
}
