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
      echo 'Current User: ID '.$_SESSION['User']['UserID'].', Email '.$_SESSION['User']['Email'].'.<br>';
      echo 'Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds.<br>";
      echo 'Ran '.$NUMBER_OF_QUERIES_RUN.' <a href="javscript:void(0);" onclick="$(\'#queriesRun\').slideToggle();">Queries</a>.<br>';
      echo 'Session Expires '.date('r',$_SESSION['Auth']['Expires']).'.<br>';
    ?>
  </div>
  
  <button onclick="$('#debug').slideToggle();" type="button" class="btn btn-outline-primary">Debug</button>
  <button onclick="$('#debugSummary').slideToggle();" type="button" class="btn btn-outline-primary">Hooks</button>
  <button onclick="$('#queriesRun').slideToggle();" type="button" class="btn btn-outline-primary">Queries</button>
  <button onclick="$('#session').slideToggle();" type="button" class="btn btn-outline-primary">Session</button>
  <br><br>
</div>
<div class="row">
  <div class="col-xs-12 hidden_box" id="hooks">
    <h2>Current Hooks</h2>
    <?php pd($EVENTS); ?>
  </div>
  <div class="col-xs-12 hidden_box" id="debugSummary">
    <h2>Debug Summary</h2>
    <?php DebugShowSummary(); ?>
  </div>
  <div class="col-xs-12 hidden_box" id="queriesRun">
    <?php 
      pd(htmlentities($QUERIES_RUN));
    ?>
  </div>
  <div class="col-xs-12 hidden_box" id="session">
    Disabled during development until permissions are completed.
    <?php 
      //TODO
      //pd(htmlentities(var_export($_SESSION,true)));
    ?>
  </div>
</div>
<?php
}
