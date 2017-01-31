<?php

function showEditHook(){
  Hook('Template Body','EditHookBodyCallback();');
  TemplateBootstrap2('Edit Hook| Architect'); 

}

function EditHookBodyCallback(){
  ?>
  <h1>Edit Hook</h1>
  
  
  <?php
}
