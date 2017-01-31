<?php

function ArchitectEditViewNewHook(){
  Hook('Template Body','ArchitectEditViewNewHookBodyCallback();');
  TemplateBootstrap4('New Hook - Architect'); 
}
function ArchitectEditViewNewHookBodyCallback(){
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
        <h1>New Event-Driven Function</h1>
        <?php
          
          $Editable=array(
            'Astria Event'  => '',
            'Code'          => ''
          );
          $Readable=array(
            'View'  => $View['ViewID']
          );
          AstriaBootstrapAutoForm($Editable,$Readable);
  
        ?>
        <br>
        <br>
      </div>
    </div>
</div>

<?php
  
}
