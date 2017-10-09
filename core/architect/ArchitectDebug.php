<?php

function ArchitectDebug(){
    TemplateBootstrap4('Debug - Architect','AArchitectDebugBodyCallback();'); 
}

function AArchitectDebugBodyCallback(){
  ?>
  
  <h1>Debug</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php echo ArrTabler(Query("
        
          SELECT * FROM Debug LIMIT 10
        
        ")); ?>
      </div>
    </div>
  </div>
  
  <?php
}
