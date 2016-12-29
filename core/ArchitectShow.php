<?php

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
      echo '<p>Current User: ID '.$_SESSION['User']['UserID'].', Email '.$_SESSION['User']['Email'].'.';
      echo ' Runtime '.round(microtime(true)-$DEBUG[0]['timestamp'],4)." seconds.";
      echo ' Ran '.$NUMBER_OF_QUERIES_RUN.' Queries.';
      echo ' Session Expires '.date('r',$_SESSION['Auth']['Expires']).'.</p>';
    ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <form class="form-inline">
      <button onclick="Cardify('Events','debugSummary');" type="button" class="btn btn-outline-warning">Events</button>
      <button onclick="Cardify('Hooks','hooks');" type="button" class="btn btn-outline-warning">Hooks</button>
      <button onclick="Cardify('Queries','queriesRun');" type="button" class="btn btn-outline-warning">Queries</button>
      <button onclick="Cardify('Session','session');" type="button" class="btn btn-outline-warning">Session</button>
      <button onclick="Cardify('Databases','databases');" type="button" class="btn btn-outline-warning">Databases</button>
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
  <div class="hidden" id="databases">
    <?php 
      global $ASTRIA;
      $temp=array();
      foreach($ASTRIA['databases'] as $name => $database){
        $temp[$name] => $database['resource'];
      }
      pd(htmlentities(var_export($temp,true)));
    ?>
  </div>
  <div class="hidden" id="newView">
    <form action="/architect/new-view" method="post">
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="View Name" name="newViewName" id="newViewName">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Description" name="newViewDescription" id="newViewDescription">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Slug" name="newViewSlug" id="newViewSlug">
        </div>
      </div>
      <div class="form-group row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-success">Create View</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
}
