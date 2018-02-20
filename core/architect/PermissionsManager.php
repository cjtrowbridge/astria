<?php

function PermissionsManager(){
  //Make sure user is an admin
  if(!IsAstriaAdmin()){die('You may not manage permissions.');}
  
  //Handle posts and update objects
  if(
    isset($_POST['UserID'])||
    isset($_POST['GroupID'])
  ){
    global $ASTRIA;
    
    //make a list of all the boxes that were checked and decode from base64
    $Input = array();
    foreach($_POST as $Key => $Value){
      if(
        ($Key == 'GroupID')||
        ($Key == 'UserID')
      ){
        continue;
      }
      $Decoded = base64_decode($Key);
      $Input[$Decoded]=$Decoded;
    }
    
    
    //make a list of all current permissions
    $Current=array();
    if(isset($_POST['UserID'])){
      //global $ASTRIA;
      //$Current = $ASTRIA['Session']['Permissions'];
      
      $SQL="SELECT Text FROM Permission WHERE Permission.UserID = ".intval($_POST['UserID']);
      $UserPermissions = Query($SQL);
      foreach($UserPermissions as $UserPermission){
        $Current[$UserPermission['Text']]=$UserPermission['Text'];
      }
      unset($UserPermissions);
      
    }elseif(isset($_POST['GroupID'])){
      $SQL="SELECT Text FROM Permission WHERE Permission.GroupID = ".intval($_POST['GroupID']);
      $GroupPermissions = Query($SQL);
      foreach($GroupPermissions as $GroupPermission){
        $Current[$GroupPermission['Text']]=$GroupPermission['Text'];
      }
      unset($GroupPermissions);
    }
    
    
    //make a list of anything that needs to be removed
    $Remove = array();
    foreach($Current as $Key => $Value){
      if(!isset($Input[$Key])){
       $Remove[$Key]=$Key; 
      }
    }
    
    
    //make a list of anything that needs to be added
    $Add = array();
    foreach($Input as $Key => $Value){
      if(!isset($Current[$Key])){
       $Add[$Key]=$Key; 
      }
    }
    
    /*
    echo '<p>Input</p>';
    pd($Input);
    echo '<p>Add</p>';
    pd($Add);
    echo '<p>Remove</p>';
    pd($Remove);
    */
    
    
    if(isset($_POST['UserID'])){
      
      foreach($Add as $Key => $Value){
        $Permission = Sanitize($Key);
        $UserID = intval($_POST['UserID']);
        $SQL="INSERT INTO `Permission` (
            `UserID`, `Text`, `UserInserted`, `TimeInserted`, `InsertedUser`, `InsertedTime`
          ) VALUES (
            '".$UserID."','".$Permission."',  '".$ASTRIA['Session']['User']['UserID']."', NOW(), '".$ASTRIA['Session']['User']['UserID']."', NOW()
          );
        ";
        pd($SQL);
        Query($SQL);
      }
      foreach($Remove as $Key => $Value){
        $Permission = Sanitize($Key);
        $UserID = intval($_POST['UserID']);
        $SQL="DELETE FROM `Permission` 
          WHERE Text LIKE '".$Permission."' AND
          UserID = '".$UserID."'
          ;
        ";
        pd($SQL);
        Query($SQL);
      }
      
    }elseif(isset($_POST['GroupID'])){
      
      foreach($Add as $Key => $Value){
        $Permission = Sanitize($Key);
        $GroupID = intval($_POST['GroupID']);
        $SQL="INSERT INTO `Permission` (
            `GroupID`, `Text`, `UserInserted`, `TimeInserted`, `InsertedUser`, `InsertedTime`
          ) VALUES (
            '".$GroupID."','".$Permission."',  '".$ASTRIA['Session']['User']['UserID']."', NOW(), '".$ASTRIA['Session']['User']['UserID']."', NOW()
          );
        ";
        pd($SQL);
        Query($SQL);
      }
      foreach($Remove as $Key => $Value){
        $Permission = Sanitize($Key);
        $GroupID = intval($_POST['GroupID']);
        $SQL="DELETE FROM `Permission` 
          WHERE Text LIKE '".$Permission."' AND
          GroupID = '".$GroupID."'
          ;
        ";
        pd($SQL);
        Query($SQL);
      }
      
    }
    
    header('Location: /architect/permissions-manager');
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
    
    
    
    //make a list of all current permissions
    $Current=array();
    if(isset($_GET['UserID'])){
      $SQL="SELECT Text FROM Permission WHERE Permission.UserID = ".intval($_GET['UserID']);
      $UserPermissions = Query($SQL);
      foreach($UserPermissions as $UserPermission){
        $Current[$UserPermission['Text']]=$UserPermission['Text'];
      }
      unset($UserPermissions);
      
    }elseif(isset($_GET['GroupID'])){
      $SQL="SELECT Text FROM Permission WHERE Permission.GroupID = ".intval($_GET['GroupID']);
      $GroupPermissions = Query($SQL);
      foreach($GroupPermissions as $GroupPermission){
        $Current[$GroupPermission['Text']]=$GroupPermission['Text'];
      }
      unset($GroupPermissions);
    }
    
    
    ?>
    <p><a href="/architect/permissions-manager">&lt;- Back</a></p>
    <?php
    
    //verify the group or user
    if(isset($_GET['UserID'])){
      $User = Query("SELECT UserID, FirstName, LastName, Email FROM User WHERE UserID = ".intval($_GET['UserID']));
      if(!isset($User[0])){
        echo 'Invalid User';
        return;
      }
      $User = $User[0];
    }
    if(isset($_GET['GroupID'])){
      $Group = Query("SELECT GroupID, Name FROM UserGroup WHERE GroupID = ".intval($_GET['GroupID']));
      if(!isset($Group[0])){
        echo 'Invalid Group';
        return;
      }
      $Group = $Group[0];
    }
    ?>

    <h1>Modifying <?php
    
    if(isset($_GET['UserID'])){
      echo 'User '.$_GET['UserID'].': &quot;'.$User['FirstName'].' '.$User['LastName'].' &lt;'.$User['Email'].'&gt;&quot;';
    }
    if(isset($_GET['GroupID'])){
      echo 'Group '.$_GET['GroupID'].': &quot;'.$Group['Name'].'&quot;';
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
      echo PHP_EOL.'<p class="permissionOption" data-value="'.str_replace('"',' ',$Permission).'"><label><input type="checkbox" name="'.base64_encode($Permission).'" value="yes"';
      
      //check the box by default if they already have this permission
      if(isset($Current[$Permission])){
        echo ' checked="checked"';
      }
      
      echo '> '.$Permission.'</label></p>'.PHP_EOL;
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
