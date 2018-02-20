<?php

function PermissionsManager(){
  //Make sure user is an admin
  if(!IsAstriaAdmin()){die('You may not manage permissions.');}
  
  //Handle posts and update objects
  if(
    isset($_POST['UserID'])||
    isset($_POST['GroupID'])
  ){
    pd($_POST);
    
    //header
    exit;
  }
  
  TemplateBootstrap4('Permissions Manager','PermissionsManagerBodyCallback();');
}

function PermissionsManagerBodyCallback(){
  
  //if a user or group is selected, show the options
  if(
    isset($_GET['UserID']) ||
    isset($_GET['GroupID'])
  ){
    
    ?>
    <p><a href="/architect/permissions-manager">&lt;- Back</a></p>
    <?php
    
    //verify the group or user
    if(isset($_GET['UserID'])){
      $User = Query("SELECT FirstName, LastName, Email FROM User WHERE UserID = ".intval($_GET['UserID']));
      if(!isset($User[0])){
        echo 'Invalid User';
        return;
      }
      $User = $User[0];
    }
    if(isset($_GET['GroupID'])){
      $Group = Query("SELECT Name FROM UserGroup WHERE GroupID = ".intval($_GET['GroupID']));
      if(!isset($Group[0])){
        echo 'Invalid Group';
        return;
      }
      $Group = $Group[0];
    }
    ?>

    <h1>Modifying <?php
    
    if(isset($_GET['UserID'])){
      'User '.$_GET['UserID'].': '.$User['FirstName'].' '.$User['LastName'].', '.$User['Email'];
    }
    if(isset($_GET['GroupID'])){
      'Group '.$_GET['GroupID'].': '.$Group['Name'];
    }
    
    ?></h1>
    <h2>Select From The Available Permissions:</h2>
    <input type="text" class="form-control" id="permissionOptionFilter">
    <script>
      $("#permissionOptionFilter").keyup(function(){
        applyFilter($('#permissionOptionFilter').val());
      });
      
      function applyFilter(query){
        query = query.toLowerCase();
        if(query.length == 0){
          //$('#unfilterAll').hide();
          $(".permissionOption" ).show();
        }else{
          $('#unfilterAll').show();
          $(".permissionOption").each(function( index, element ){
            
            var text = $(this).data('value');
            
            if( text.toLowerCase().indexOf(query) >= 0){
              $(this).show();
            }else{
              $(this).hide();
            }
          });
        }
      }

    </script>
    <form action="/architect/permissions-manager" method="post">
    <?php
    
    if(isset($_GET['UserID'])){
      echo '<input type="hidden" name="UserID" value="'.$User['UserID'].'">';
    }
    if(isset($_GET['GroupID'])){
      echo '<input type="hidden" name="GroupID" value="'.$Group['GroupID'].'">';
    }
    
    global $ASTRIA;
    foreach($ASTRIA['Session']['AllPermissions'] as $Permission){
      echo PHP_EOL.'<p class="permissionOption" data-value="'.str_replace('"',' ',$Permission).'"><label><input type="checkbox" name="selectedPermission[]" value="'.base64_encode($Permission).'"> '.$Permission.'</label></p>'.PHP_EOL;
    }
    
    ?>
      <p><input type="submit" class="btn btn-block btn-success" value="Save"></p>
    </form>
    <?php
    
    return;
  }
  
  //If no user or group has been selected, then show a list of them
  ?><h1>Select a User or Group to Edit Permissions...</h1>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h2>Users</h2>
        <?php
          $SQL = "SELECT UserID, Email, FirstName, LastName FROM User WHERE UserID != 0";
          $Users = Query($SQL);
          foreach($Users as $User){
            ?>
            <div class="card">
              <div class="card-block">
                <div class="card-text">
                  <?php echo '<b>'.$User['FirstName'].' '.$User['LastName'].'</b><br><a href="/architect/permissions-manager/?UserID='.$User['UserID'].'">'.$User['Email'].'</a>'; ?>
                </div>
              </div>
            </div>
            <?php
          }
        ?>
      </div>
      <div class="col-xs-12 col-md-6">
        <h2>Groups</h2>
        <?php
          $SQL = "SELECT GroupID, Name, Description FROM UserGroup";
          $Groups = Query($SQL);
          foreach($Groups as $Group){
            ?>
            <div class="card">
              <div class="card-block">
                <div class="card-text">
                  <?php echo '<a href="/architect/permissions-manager/?GroupID='.$Group['GroupID'].'">'.$Group['Name'].'</a>'; ?>
                </div>
              </div>
            </div>
            <?php
          }
        ?>
      </div>
    </div>
  </div>
  <?php
}
