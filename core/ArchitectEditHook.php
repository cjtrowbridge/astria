<?php

function showEditHook(){
  Hook('Template Body','EditHookBodyCallback();');
  TemplateBootstrap4('Edit Hook | Architect'); 

}

function EditHookBodyCallback(){
  ?>
  <h1>Edit Hook</h1>
  <?php
  $HookID = intval(path(2));
  if($HookID==0){echo '<p>Please Specify a HookID. For example /architect/edit-hook/1</p>';return;}
  
  $Hook = Query('SELECT * FROM Hook WHERE HookID = '.$HookID);
  pd($Hook);
}
