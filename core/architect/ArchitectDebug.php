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
        <p><i>Data Since <?php echo ago(Query("SELECT MIN(Timestamp) as Min FROM Debug")[0]['Min']); ?>.</i></p>
        <?php 
          
          echo ArrTabler(Query("
            SELECT * FROM (
              SELECT 
                Description,
                ROUND(AVG(RAM),2) AS 'AVG RAM',
                ROUND(AVG(RunTime),2) as 'AVG Runtime'

              FROM Debug 

              GROUP BY Description
            ) x

            ORDER BY Runtime DESC

          ")); 
        ?>
      </div>
    </div>
  </div>
  
  <?php
}
