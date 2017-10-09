<?php

function ArchitectUserGroupMembership(){
  
  TemplateBootstrap4('User Group Membership - Architect','ArchitectUserGroupMembershipBodyCallback();'); 
}
function ArchitectUserGroupMembershipBodyCallback(){
  ?>
  
  <h1>User Group Membership</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php echo ArrTabler(Query("SELECT * FROM UserGroupMembership")); ?>
      </div>
    </div>
  </div>
  
  <?php
}
