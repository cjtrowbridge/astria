<?php

function ArchitectSchemaHUD(){
  TemplateBootstrap4('Schema HUD','ArchitectSchemaHUDBodyCallback();');
}

function ArchitectSchemaHUDBodyCallback(){
  global $ASTRIA;
  ?><h1>Schema - Architect</h1>
  
  <?php
  foreach($ASTRIA['databases'] as $Alias => $Database){
    ?>
    
    <div class="card">
      <div class="card-block">
        <h4 class="card-title">Database: "<?php echo $Alias; ?>"</h4>
        <p>
          <b><?php echo $Database['type'].'://'.$Database['hostname']; ?></b>
          (<?php  
            if($Database['resource']===false){
              echo 'Not Connected';
            }else{
              echo 'Connected';
            }
          ?>)
        </p>
      </div>
    </div>

    <?php
  }
  
}
