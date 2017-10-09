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
        
          SELECT 
            Description,
            ROUND(AVG(RAM),2) AS RAM,
            ROUND(AVG(RunTime),2) as Runtime
          
          FROM Debug 
          
          GROUP BY Description
        
        ")); ?>
      </div>
    </div>
  </div>
  
  <?php
}
