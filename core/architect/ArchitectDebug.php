<?php

function ArchitectEventDebug(){
    TemplateBootstrap4('Debug - Architect','ArchitectEventDebugBodyCallback();'); 
}

function ArchitectEventDebugBodyCallback(){
  ?>
  
  <h1>Event Debugging</h1>
  
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
