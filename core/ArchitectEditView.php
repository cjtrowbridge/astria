<?php

function ArchitectEditView(){
   if(isset($_POST['ViewID'])){
    global $USER,$ASTRIA;
    
    //Validate ViewID 
    $ViewID = intval($_POST['ViewID']);
    if($ViewID==0){echo '<p>Please Specify a ViewID. For example /architect/edit-view/1</p>';return;}
    
    //Get it from the database and make sure it exists
    $View = Query('SELECT ViewID FROM View WHERE ViewID = '.$ViewID);
    if(!(isset($View[0]))){die('That view was not found. :[');}
    $View=$View[0];
    
    $NewName        = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['View_Name']);
    $NewSlug        = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['View_Slug']);
    $NewDescription = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['View_Description']);
    
    Query("UPDATE `View` SET `Name` = '".$NewName."', `Slug` = '".$NewSlug."', `Description` = '".$NewDescription."', `UpdatedUser` = '".$USER['UserID']."', `UpdatedTime` = NOW() WHERE `View`.`ViewID` = ".$View['ViewID'].";");
    header('Location: /architect/edit-view/'.$_POST['ViewID']);
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
      <h3>These Event-Driven Functions Are Associated With This View: <button type="button" class="btn btn-secondary btn-sm float-xs-right" onclick="window.open('/architect/edit-view/<?php echo path(2); ?>/new-hook/', '_blank');">New Hook</button></h3>

      <?php
        $Functions=Query("SELECT * FROM Hook WHERE ViewID = ".$View['ViewID']);
        foreach($Functions as $Function){
          $Content        = base64_decode($Function['Content']);
          $FunctionName   = $Function['Event'];
          $TextareaName   = 'Code';
          ?>
          <div class="box">
            <p>&lt;?php </p>   
            <form action="/architect/edit-hook/<?php echo $Function['HookID']; ?>" method="post">
              <?php AstriaHookEditor($Content,$FunctionName,$TextareaName); ?>
              <input type="hidden" name="HookID" id="HookID" value="<?php echo $Function['HookID']; ?>">
              <button type="submit" class="btn btn-secondary btn-sm float-xs-right">Save</button>
            </form>
            <p>?&gt;</p>
            <div class="clearer"></div>
          </div>
          <?php

        }
      ?>
         

      <h3>User and Group Permissions Associated With This View <button type="button" class="btn btn-secondary btn-sm float-xs-right" onclick="window.open('/architect/edit-view/<?php echo path(2); ?>/new-permission/', '_blank');">New Permission</button></h3>
      <?php echo ArrTabler(Query("SELECT * FROM Permission WHERE ViewID = ".$View['ViewID'])); ?>

      <h3>Details</h3>
      <?php
         
        $Editable=array(
          'View Name'        => $View['Name'],
          'View Slug'        => $View['Slug'],
          'View Description' => $View['Description']

        );
        $Readable=array(
          'ViewID'  => $View['ViewID']
        );
        $Hidden=array(
          'ViewID'  => $View['ViewID']
        );
        echo AstriaBootstrapAutoForm($Editable,$Readable,$Hidden,'Current URL','post',false);
      ?>
    </div>
  </div>
</div>




<?php
  
}
