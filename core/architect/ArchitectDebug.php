<?php

function ArchitectEventDebug(){
    TemplateBootstrap4('Debug - Architect','ArchitectEventDebugBodyCallback();'); 
}

function ArchitectEventDebugBodyCallback(){
  ?>
  
  <h1>Event Debugging</h1>
  
  <a href="/?DebugServiceDumpToDatabaseOverride" class="btn btn-outline-warning">Dump Debug Data To DB Now</a>

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
          ORDER BY 'Runtime' DESC
        
        ")); ?>
      </div>
    </div>
  </div>
  
  <?php
}
