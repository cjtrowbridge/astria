<?php

function showNewPermission(){
  if(isset($_POST['ViewID'])){
    //Creating a new view permission!
    global $ASTRIA;
    MakeSureDBConnected();
    
    //Validate ViewID 
    $ViewID = intval($_POST['ViewID']);
    if($ViewID==0){echo '<p>Please Specify a ViewID. For example /architect/edit-view/1</p>';return;}
    
    //Get it from the database and make sure it exists
    $View = Query('SELECT ViewID FROM View WHERE ViewID = '.$ViewID);
    if(!(isset($View[0]))){die('That view was not found. :[');}
    $View=$View[0];
    
    $newEvent = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['Astria_Event']);
    $newCode  = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],base64_encode($_POST['Code']));
    
    //Query("INSERT INTO `Hook` (`ViewID`, `Event`, `Content`,`InsertedTime`,`InsertedUser`) VALUES ('".$View['ViewID']."', '".$newEvent."', '".$newCode."',NOW(),".intval($ASTRIA['Session']['User']['UserID']).");");
    
    //header('Location: /architect/edit-view/'.$ViewID);
    exit;
    
  }
  Hook('Template Body','ArchitectEditViewNewPermissionBodyCallback();');
  TemplateBootstrap4('New Hook - Architect'); 
}
function ArchitectEditViewNewPermissionBodyCallback(){
  global $ASTRIA;
  MakeSureDBConnected();
  
  if(intval(trim(path(2)))>0){
    //look up by id
    $sql="
      SELECT * FROM View
      WHERE View.ViewID = ".intval(path(2))."
    ";
    $View=Query($sql);
  }else{
    //try looking up by slug
    $safeslug=mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],path(2));
    $sql="
      SELECT * FROM View
      WHERE View.Slug LIKE '".$safeslug."'
    ";
    $View=Query($sql);
  }
  if(!(isset($View[0]))){
    echo '<h1>View Not Found!</h1>';
    return false;
  }
  $View=$View[0];
  
  
  ?>

<div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>New Permission</h1>
        <p>Select a user or group or both in order to grant permission for this view.</p>
        <?php
          
          $Editable=array(
            'Group'  => '1',
            'User'   => '1'
          );
          $Readable=array(
            'ViewID'  => $View['ViewID']
          );
          $Hidden=array(
            'ViewID'  => $View['ViewID']
          );
          echo AstriaBootstrapAutoForm($Editable,$Readable,$Hidden);
  
        ?>
        <br>
        <br>
      </div>
    </div>
</div>

<?php
  
}
