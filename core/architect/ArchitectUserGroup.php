<?php

function ArchitectUserGroup(){
  
  TemplateBootstrap4('User Group - Architect','ArchitectUserGroupBodyCallback();'); 
}
function ArchitectUserGroupBodyCallback(){
  ?>
  
  <h1>User Group</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php echo ArrTabler(Query("SELECT * FROM UserGroup")); ?>
      </div>
    </div>
  </div>
  
  <?php
}
