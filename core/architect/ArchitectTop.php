<?php

function ArchitectTop(){
  TemplateBootstrap4('Top - Architect' , 'ArchitectTopBodyCallback();');
}

function ArchitectTopBodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/top">top</a></h1>
  
  <h2>df -h</h2>
  <pre><?php passthru(passthru('/usr/bin/top -b -n 1'); ?></pre>
    
  <?php
}
