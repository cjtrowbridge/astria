<?php

function PermissionsManager(){
  //Handle posts and update objects
  
  
  TemplateBootstrap4('Permissions Manager','PermissionsManagerBodyCallback();');
}

function PermissionsManagerBodyCallback(){



  ?><h1>Select a User or Group to Edit Permissions...</h1>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h2>Users</h2>
        <?php
          $SQL = "SELECT UserID, Email, FirstName, LastName FROM User";
          $Users = Query($SQL);
          echo ArrTabler($Users);
        ?>
      </div>
      <div class="col-xs-12 col-md-6">
        <h2>Groups</h2>
        <?php
          $SQL = "SELECT GroupID, Name, Description FROM UserGroup";
          $Groups = Query($SQL);
          echo ArrTabler($Groups);
        ?>
      </div>
    </div>
  </div>
  <?php
}
