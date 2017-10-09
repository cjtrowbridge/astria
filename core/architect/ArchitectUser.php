<?php

function ArchitectUser(){

    TemplateBootstrap4('User - Architect','ArchitectUserBodyCallback();'); 
}
function ArchitectUserBodyCallback(){
  ?>
  
  <h1>Users</h1>
  
  <div class="card">
    <div class="card-block">
      <div class="card-text">
        <?php echo ArrTabler(Query("SELECT * FROM User"));
      </div>
    </div>
  </div>
  
  <?php
}
