<?php

function ArchitectGitWebhooks(){

  TemplateBootstrap4('Git Webhooks - Architect','ArchitectGitWebhooksBodyCallback();');
}

function ArchitectGitWebhooksBodyCallback(){
  global $ASTRIA;

?>

<h1>Git Webhooks</h1>

<div class="card">
  <div class="card-block">
    <div class="card-text">
      <div id="PullMainlineWebhook">
        <h2>Webhook: Pull Mainline from Github</h2>
        <a target="_blank" href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>"><?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-block">
    <div class="card-text">
      <div id="GetSubrepositoryPullWebhook">
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
                          echo '<li>';
                          if(!(is_dir('plugins/'.$File.'/.git'))){
                            echo '<p>This does not appear to be a git repository.</p>'
                          }
                          echo '<a href="javascript:void(0);" onclick="$(\'#subrepositoryPath\').val(\'/plugins/'.$File.'\');GetSubrepositoryPullWebhook();">'.$File.'</a></li>';
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
    </div>
  </div>
</div>

<?php
}
