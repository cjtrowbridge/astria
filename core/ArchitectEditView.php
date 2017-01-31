<?php

function ArchitectEditView(){
   if(isset($_POST['ViewID'])){
    global $USER,$ASTRIA;
    
    pd($_POST);exit;
     
    $ViewID = intval($_POST['ViewID']);
    if($ViewID==0){echo '<p>Please Specify a ViewID. For example /architect/edit-view/1</p>';return;}
    //Get it from the database and make sure it exists
    $View = Query('SELECT ViewID FROM View WHERE ViewID = '.$ViewID);
    if(!(isset($View[0]))){die('That view was not found. :[');}
    $View=$View[0];
    
    $NewName        = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['Astria_Event']);
    $NewSlug        = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['Code']);
    $NewDescription = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['Code']);
    
    $SQL="UPDATE `Hook` SET `Event` = '".$NewEvent."', `Content` = '".$NewContent."', `UpdatedUser` = '".$USER['UserID']."', `UpdatedTime` = NOW() WHERE `Hook`.`HookID` = ".$Hook['HookID'].";";
    Query($SQL);
    pd($SQL);
    header('Location: /architect/edit-hook/'.$_POST['HookID']);
    exit;
    
  }
  
  Hook('Template Body','ArchitectEditViewBodyCallback();');
  TemplateBootstrap4('Edit View - Architect'); 
}
function ArchitectEditViewBodyCallback(){
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
        <h1>Edit View: <?php echo $View['Name']; ?></h1>
        
        <div class="row">
          <?php
            $Editable=array(
              'View Name'        => $View['Name'],
              'View Slug'        => $View['Slug'],
              'View Description' => $View['Description']

            );
            $Readable=array(
              'ViewID'  => $View['ViewID']
            );
            echo AstriaBootstrapAutoForm($Editable,$Readable);
          ?>
        </div>
        <div class="row">
          <div class="col-xs-12">
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <h3>These Event-Driven Functions Are Associated With This View: <button type="button" class="btn btn-secondary btn-sm float-xs-right" onclick="window.open('/architect/edit-view/<?php echo path(2); ?>/new-hook/', '_blank');">New Hook</button></h3>
            <?php
              echo ArrTabler(Query("SELECT * FROM Hook WHERE ViewID = ".$View['ViewID']));
            ?>
          </div>
        <div class="row">
          <div class="col-xs-12">
            &nbsp;
          </div>
        </div>
          <div class="col-xs-12">
            <h3>User and Group Permissions Associated With This View <button type="button" class="btn btn-secondary btn-sm float-xs-right" onclick="window.open('/architect/edit-view/<?php echo path(2); ?>/new-permission/', '_blank');">New Permission</button></h3>
            <?php
              echo ArrTabler(Query("SELECT * FROM Permission WHERE ViewID = ".$View['ViewID']));
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            &nbsp;
          </div>
        </div>
      </div>
    </div>
</div>




<?php
  
}
