<?php

function ArchitectUserGroupMembership(){
  
  TemplateBootstrap4('User Group Membership - Architect','ArchitectUserGroupMembershipBodyCallback();'); 
}
function ArchitectUserGroupMembershipBodyCallback(){
  ?>
  
  <h1>UserGroupMembership</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php 
          global $ASTRIA;
          $DBName = $ASTRIA['databases']['astria']['database'];
          $TableExists = Query("SELECT count(*) as 'Found' FROM information_schema.tables WHERE table_schema = '$DBName' AND table_name = 'UserMembership';");
          if($TableExists[0]['Found']==0){
            Query("ALTER TABLE `UserMembership` RENAME `UserGroupMembership`;");
          }
          echo ArrTabler(Query("SELECT * FROM UserGroupMembership")); 
        ?>
      </div>
    </div>
  </div>
  
  <?php
}
