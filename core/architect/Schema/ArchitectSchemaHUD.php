<?php

function ArchitectSchemaHUD(){
  TemplateBootstrap4('Schema HUD','ArchitectSchemaHUDBodyCallback();');
}

function ArchitectSchemaHUDBodyCallback(){
  global $ASTRIA;
  ?><h1>Schema - Architect</h1>
  
  <?php
  foreach($ASTRIA['databases'] as $Database){
    ?>
    
    <div class="card">
      <div class="card-block">
        <h4 class="card-title"><?php echo $Database['name']; ?></h4>
        <?php
          pd($Database);
        ?>
      </div>
    </div>

    <?php
  }
  
}
