<?php

function ArchitectIfconfig(){
  TemplateBootstrap4('Top - Architect' , 'ArchitectIfconfigBodyCallback();');
}
function ArchitectIfconfigBodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/ifconfig">ifconfig</a></h1>
  
  <h2>/sbin/ifconfig</h2>
  <pre><?php passthru('/sbin/ifconfig'); ?></pre>
    
  <?php
}
