<?php

include_once('Path.php');

Hook('User Is Logged In - Before Presentation','prepareArchitect();');

function prepareArchitect(){
  if(
    path()=='architect'
    //&& TODO Should user be able to see this?
  ){
    
    Hook('User Is Logged In - Presentation','showArchitect();');
    
  }
}

function showArchitect(){
  Hook('Template Body','ArchitectBodyCallback();');
  TemplateBootstrap2('Architect'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS, $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG;
  ?>
<h1>Architect</h1>
<div class="row">
  <div class="col-xs-12">
    <?php
      echo 'User '.$_SESSION['User']['Email'].' is logged in, but nothing happened at this url.<br>';
      echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds.<br>";
      echo 'Ran '.$NUMBER_OF_QUERIES_RUN.' <a href="javscript:void(0);" onclick="$(\'#queriesRun\').slideToggle();">Queries</a>.<br>';
    ?>
  </div>
  <div class="col-xs-12" id="queriesRun" style="display: none;">
    <?php 
      pd(htmlentities($QUERIES_RUN));
    ?>
  </div>
    <?php
      echo 'Session Expires '.date('r',$_SESSION['Auth']['Expires']).'.<br>';
    ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-5">
    <h2>Current Hooks</h2>
    <?php pd($EVENTS); ?>
  </div>
  <div class="col-xs-12 col-md-7">
    <h2>Debug Summary</h2>
    <?php DebugShowSummary(); ?>
  </div>
  </div>
<?php
}
