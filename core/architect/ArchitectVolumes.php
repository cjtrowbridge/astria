<?php

function ArchitectVolumes(){
  TemplateBootstrap4('Volumes - Architect' , 'ArchitectVolumesBodyCallback();');
}

function ArchitectVolumesBodyCallback(){
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/volumes">Volumes</a></h1>
  
  <h2>df -h</h2>
  <pre><?php passthru('df -h'); ?></pre>
    
  <?php
}
