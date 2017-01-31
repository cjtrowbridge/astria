<?php

function showEditHook(){
  if(isset($_POST['HookID'])){
    pd($_POST);
    die('Handle Post for Edit-Hook'); 
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
    'EventDrivenBy' => $Hook['Event'],
    'Content' => $Hook['Content']
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
