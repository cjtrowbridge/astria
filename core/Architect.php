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
</div>
<div class="row">
  <div class="col-xs-12">
    <form class="form-inline">
      <button onclick="Cardify('Events','debugSummary');" type="button" class="btn btn-outline-primary">Events</button>
      <button onclick="Cardify('Hooks','hooks');" type="button" class="btn btn-outline-primary">Hooks</button>
      <button onclick="Cardify('Queries','queriesRun');" type="button" class="btn btn-outline-primary">Queries</button>
      <button onclick="Cardify('Events','session');" type="button" class="btn btn-outline-primary">Session</button>
    </form><br>
    <form class="form-inline">
      <button onclick="Cardify('New View','newView');" type="button" class="btn btn-info" >New View</button>
    </form>
  </div>
</div><br>
<div class="row">
  <div class="hidden" id="hooks">
    <?php pd($EVENTS); ?>
  </div>
  <div class="hidden" id="debugSummary">
    <?php DebugShowSummary(); ?>
  </div>
  <div class="hidden" id="queriesRun">
    <?php 
      pd(htmlentities($QUERIES_RUN));
    ?>
  </div>
  <div class="hidden" id="session">
    <?php 
      $temp=$_SESSION;
      unset($temp['google_oauth2']);
      pd(htmlentities(var_export($temp,true)));
    ?>
  </div>
  <div class="hidden" id="newView">
    <div class="form-group row">
      <div class="col-xs-12">
        <input type="text" class="form-control" placeholder="View Name">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <input type="text" class="form-control" placeholder="Description">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <button type="button" class="btn btn-success">Create View</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#search').focus();
  $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });
</script>
<?php
}
