<?php

function ArchitectSession(){
  TemplateBootstrap4('Session - Architect' , 'ArchitectSessionBodyCallback();');
}
function ArchitectSessionBodyCallback(){
  global $ASTRIA;
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/session">Session</a></h1>
  
  <pre><?php ps($ASTRIA['Session']); ?></pre>
    
  <?php
}
