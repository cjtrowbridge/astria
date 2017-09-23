<?php

function showArchitect(){
  TemplateBootstrap4('Architect','ArchitectBodyCallback();'); 
}
  
function ArchitectBodyCallback(){
  global $EVENTS, $NUMBER_OF_QUERIES_RUN, $QUERIES_RUN, $DEBUG, $NUMBER_OF_QUERIES_RUN_FROM_DISK_CACHE,$ASTRIA;
  ?>
<h1>Architect 
  
  <span style="float: right;">
    <a href="https://github.com/cjtrowbridge/astria" target="_blank"><svg height="24" class="octicon octicon-mark-github" viewBox="0 0 16 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg></a>
    <a href="/architect/configuration" target="_blank" style="color: #000;"><i class="material-icons">settings</i></a>
  </span>
</h1>

<div class="row">
  <div class="col-xs-12">
    <div class="form-inline">
      <h4>Architect Tools:</h4>
      <p>
        <a href="/architect/files" class="btn btn-outline-success">File Manager</a>
        <a href="/architect/files" class="btn btn-outline-success"><i class="material-icons">storage</i> Volumes</a>
      </p>
      <p>
        <a href="/architect/feedsync" class="btn btn-outline-success">FeedSync</a>
        <button onclick="document.location='/architect/schema'" type="button" class="btn btn-outline-success">Schema</button>
        <button onclick="Cardify('Events','events');" type="button" class="btn btn-outline-success">Events</button>
        <button onclick="Cardify('Users','users');" type="button" class="btn btn-outline-success">Users</button>
        <button onclick="Cardify('Groups','groups');" type="button" class="btn btn-outline-success">Groups</button>
        <button onclick="Cardify('Session','session');" type="button" class="btn btn-outline-success">Session</button>
      </p>
      <h4>Webhooks:</h4>
      <button onclick="$('#PullMainlineWebhook').slideToggle();" type="button" class="btn btn-outline-danger">Pull Mainline</button>
      <button onclick="$('#GetSubrepositoryPullWebhook').slideToggle();" type="button" class="btn btn-outline-danger">Pull Subrepository</button>
      
    </div>
  </div>
</div><br>
<div class="row">
  <div class="hidden box" id="PullMainlineWebhook">
    <h2>Webhook: Pull Mainline from Github</h2>
    <a target="_blank" href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>"><?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?></a>
  </div>
  
  <div class="hidden box" id="GetSubrepositoryPullWebhook">
    <h2>Webhook: Pull Subrepository</h2>
    <form onsubmit="return false;" class="form">
      <div class="form-group">
        <div class="input-group">
          <div>
            <p>Here are some potential repositories I found in the plugins directory...</p>
            <ul>
            <?php
              $dir = "plugins";
              if(is_dir($dir)){
                if($dh = opendir($dir)){
                  while(($File = readdir($dh)) !== false){
                    if($File!=='.'&&$File!=='..'&&$File!=='defaultViews'){
                      echo '<li><a href="javascript:void(0);" onclick="$(\'#subrepositoryPath\').val(\'/plugins/'.$File.'\');GetSubrepositoryPullWebhook();">'.$File.'</a></li>';
                    }
                  }
                  closedir($dh);
                }
              }
            ?>
            </ul>
          </div>
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
</div>
    
<div class="row">
  <div class="col-xs-12">
    <?php
      //TODO maybe show the schemas?
      Event('Architect Homepage');
    ?>
  </div>
</div>


<?php
  
$Local  = gitLocalHash();
$Global = gitGlobalHash();

if(!($Local==$Global)){
  ?>
    <div class="row">
      <div class="col-xs-12">
        <h2>Updates are Available!</h2>
        <a href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>">Pull Mainline From Github, pending an integration test.</a>
        <p>Local Master Head is at: <?php echo $Local; ?></p>
        <p>Global Master Head is at: <?php echo $Global; ?></p>
      </div>
    </div>
  <?php
}
  
?>
    
<?php
}
