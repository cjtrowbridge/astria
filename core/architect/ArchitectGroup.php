<?php

function ArchitectGroup(){
  
  TemplateBootstrap4('Group - Architect','ArchitectUserBodyCallback();'); 
}
function ArchitectGroupBodyCallback(){
  ?>
  
  <h1>Group</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php echo ArrTabler(Query("SELECT * FROM Group"));
      </div>
    </div>
  </div>
  
  <?php
}
