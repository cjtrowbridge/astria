<?php

function ArchitectDF(){
  TemplateBootstrap4('DF - Architect' , 'ArchitectDFBodyCallback();');
}

function ArchitectDFBodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/df">df</a></h1>
  
  <h2>df -h</h2>
  <pre><?php passthru('df -h'); ?></pre>
    
  <?php
}
