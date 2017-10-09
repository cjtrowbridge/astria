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
        <?php
          global $ASTRIA;
          $DBName = $ASTRIA['databases']['astria']['database'];
          $TableExists = Query("SELECT count(*) as 'Found' FROM information_schema.tables WHERE table_schema = '$DBName' AND table_name = 'UserGroup';");
          if($TableExists[0]['Found']==0){
            Query("RENAME 'Group' TO 'UserGroup';");
          }
          echo ArrTabler(Query("SELECT * FROM UserGroup")); 
          
        ?>
      </div>
    </div>
  </div>
  
  <?php
}
