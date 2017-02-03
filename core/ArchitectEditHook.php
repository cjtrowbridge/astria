<?php

function showEditHook(){
  if(isset($_POST['HookID'])){
    global $USER,$ASTRIA;
    
    $HookID = intval($_POST['HookID']);
    if($HookID==0){echo '<p>Please Specify a HookID. For example /architect/edit-hook/1</p>';return;}

    //Get it from the database and make sure it exists
    $Hook = Query('SELECT HookID FROM Hook WHERE HookID = '.$HookID);
    if(!(isset($Hook[0]))){die('That hook was not found. :[');}
    $Hook=$Hook[0];
    
    $NewEvent   = mysqli_real_escape_string($ASTRIA['databases']['astria']['resource'],$_POST['Astria_Event']);
    $NewContent = mysqli_real_escape_string(base64_encode(ASTRIA['databases']['astria']['resource'],$_POST['Code']));
    
    $SQL="UPDATE `Hook` SET `Event` = '".$NewEvent."', `Content` = '".$NewContent."', `UpdatedUser` = '".$USER['UserID']."', `UpdatedTime` = NOW() WHERE `Hook`.`HookID` = ".$Hook['HookID'].";";
    Query($SQL);
    pd($SQL);
    exit;
    header('Location: /architect/edit-hook/'.$_POST['HookID']);
    exit;
    
  }
  Hook('Template Body','EditHookBodyCallback();');
  TemplateBootstrap4('Edit Hook | Architect'); 

}

function EditHookBodyCallback(){
  ?>
  <h1>Edit Hook</h1>
  <?php
  
  //Get the HookID from the url and validate it as an integer
  $HookID = intval(path(2));
  if($HookID==0){echo '<p>Please Specify a HookID. For example /architect/edit-hook/1</p>';return;}
  
  //Get it from the database and make sure it exists
  $Hook = Query('SELECT * FROM Hook WHERE HookID = '.$HookID);
  if(!(isset($Hook[0]))){echo '<p>That hook was not found. :[</p>';return;}
  $Hook=$Hook[0];
  
  //Classify each column
  $Writeable=array(
    'Astria Event' => $Hook['Event'],
    'Code' => base64_decode($Hook['Content'])
  );
  $Readable=array(
    'ViewID' => $Hook['ViewID']
  );
  $Hidden=array(
    'HookID' => $Hook['HookID']
  );
  
  //Display the form
  ?>

  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <?php echo AstriaBootstrapAutoForm($Writeable,$Readable,$Hidden); ?>
      </div>
    </div>
</div>

  <?php
}
