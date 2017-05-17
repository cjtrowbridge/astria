<?php

function showArchitect(){
  Hook('Template Body','ArchitectBodyCallback();');
  TemplateBootstrap4('Architect'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS, $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  ?>
<h1>Architect <a href="/architect/configuration" target="_blank" style="float: right;"><i class="material-icons">settings</i></a></h1>
<div class="row">
  <div class="col-xs-12">
    <div class="form-inline">
      <button onclick="document.location='/architect/schema'" type="button" class="btn btn-outline-warning">Schema</button>
      <button onclick="Cardify('Events','events');" type="button" class="btn btn-outline-warning">Events</button>
      <button onclick="Cardify('Databases','databases');" type="button" class="btn btn-outline-warning">Databases</button>
      <button onclick="Cardify('Users','users');" type="button" class="btn btn-outline-warning">Users</button>
      <button onclick="Cardify('Groups','groups');" type="button" class="btn btn-outline-warning">Groups</button>
      <button onclick="Cardify('Session','session');" type="button" class="btn btn-outline-warning">Session</button>
    </div>
    <div class="form-inline">
      Webhooks: <button onclick="Cardify('Webhook: Pull Mainline','PullMainlineWebhook');" type="button" class="btn btn-outline-danger">Pull Mainline</button>
      
    </div>
  </div>
</div><br>
<div class="row">
  <div class="hidden" id="PullMainlineWebhook">
    <a target="_blank" href="<?php echo $ASTRIA['app']['appURL'].'/'.encrypt('Pull Mainline From Github'); ?>"><?php echo $ASTRIA['app']['appURL'].'/'.encrypt('Pull Mainline From Github'); ?></a>
  </div>
  <div class="hidden" id="session">
    <?php
      pd($ASTRIA['Session']);
    ?>
  </div>
  <div class="hidden" id="groups">
    <?php
      echo ArrTabler(Query("SELECT * FROM `Group`"));
    ?>
  </div>
  <div class="hidden" id="users">
    <?php
      echo ArrTabler(Query("
        SELECT * FROM `User`
      "));
    ?>
  </div>
  <div class="hidden" id="events">
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
  <div class="hidden" id="databases">
    <?php 
      global $ASTRIA;
      $temp=array();
      foreach($ASTRIA['databases'] as $name => $database){
        $temp[$name]=$database['resource'];
      }
      pd(htmlentities(var_export($temp,true)));
    ?>
  </div>
</div>
    
<div class="row">
  <div class="col-xs-12">
    maybe show the schemas?
  </div>
</div>
    
<?php
}
