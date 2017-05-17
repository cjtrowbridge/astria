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
      <h4>Architect Tools:</h4>
      <button onclick="document.location='/architect/schema'" type="button" class="btn btn-outline-warning">Schema</button>
      <button onclick="Cardify('Events','events');" type="button" class="btn btn-outline-warning">Events</button>
      <button onclick="Cardify('Databases','databases');" type="button" class="btn btn-outline-warning">Databases</button>
      <button onclick="Cardify('Users','users');" type="button" class="btn btn-outline-warning">Users</button>
      <button onclick="Cardify('Groups','groups');" type="button" class="btn btn-outline-warning">Groups</button>
      <button onclick="Cardify('Session','session');" type="button" class="btn btn-outline-warning">Session</button>
      
      <h4>Webhooks:</h4>
      <button onclick="Cardify('Webhook: Pull Mainline','PullMainlineWebhook');" type="button" class="btn btn-outline-danger">Pull Mainline</button>
      <button onclick="$('.GetSubrepositoryPullWebhook').slideDown();" type="button" class="btn btn-outline-danger">Pull Subrepository</button>
      
    </div>
  </div>
</div><br>
<div class="row">
  <div class="hidden" id="PullMainlineWebhook">
    <a target="_blank" href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>"><?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?></a>
  </div>
  
  <div class="hidden" id="GetSubrepositoryPullWebhook">
    <form onsubmit="return false;" class="form">
      <div class="form-group">
        <div class="input-group">
          <label for="subrepository">Email address</label>
          <input onkeyup="GetSubrepositoryPullWebhook();" type="text" class="form-control" id="subrepositoryPath" placeholder="Enter path to subrepository">
        </div>
      </div>
      <div id="GetSubrepositoryPullWebhookResult"></div>
    </form>
    <script>
      function GetSubrepositoryPullWebhook(){
        var theURL="/architect/create-webhook-pull-subrepository/?path="+$('#subrepositoryPath').val();
        console.log('Fetching: '+theURL);
        $.get(theURL, function(data){
          $("#GetSubrepositoryPullWebhookResult").html('<a target="_blank" href="'+data+'">'+data+'</a>');
        });
      }
    </script>
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
