<?php

function ArchitectUserGroup(){
  
  TemplateBootstrap4('UserGroup - Architect','ArchitectUserGroupBodyCallback();'); 
}
function ArchitectUserGroupBodyCallback(){
  ?>
  
  <h1>UserGroup</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php
          
          global $ASTRIA;
          $DBName = $ASTRIA['databases']['astria']['database'];
          $TableExists = Query("SELECT count(*) as 'Found' FROM information_schema.tables WHERE table_schema = '$DBName' AND table_name = 'UserGroup';");
          if($TableExists[0]['Found']==0){
            $SQL = "ALTER TABLE `Group` RENAME `UserGroup`;";
            Query($SQL);
            pd($SQL);
          }
          echo ArrTabler(Query("SELECT * FROM UserGroup")); 
          
        ?>
      </div>
    </div>
  </div>
  
  <?php
}
