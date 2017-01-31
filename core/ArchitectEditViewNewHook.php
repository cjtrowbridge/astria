<?php

function ArchitectEditViewNewHook(){
  Hook('Template Body','ArchitectEditViewNewHookBodyCallback();');
  TemplateBootstrap4('New Hook - Architect'); 
}
function ArchitectEditViewNewHookBodyCallback(){
  global $ASTRIA;
  MakeSureDBConnected();
  
  
  ?>

<div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>New Event-Driven Function</h1>
        <?php
          
          $Editable=array(
            
          );
          $Readable=array(
          
          );
          $Hidden=array(
          
          );
          AstriaBootstrapAutoForm($Editable,$Readable,$Hidden);
  
        ?>
        <br>
        <br>
      </div>
    </div>
</div>

<?php
  
}
