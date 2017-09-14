<?php

Hook('Webhook','RepoPull();');

function RepoPull(){
  
  //TODO figure out some kind of automated integration test to put in here
  
  $MagicWord=BlowfishEncrypt('Pull Mainline From Github');
  if(
    isset($_GET[$MagicWord])
  ){
    TemplateBootstrap4('Mainline Pull','RepoPullExecute();');
  }
}

function RepoPullExecute(){
  
    $AstriaMainlineIntegrationTest = file_get_contents('https://astria.io/test/integration');
    if(!($AstriaMainlineIntegrationTest=='ok')){
      if(!(isset($_GET['force']))){
        die('Astria <a href="https://astria.io" target="_blank">mainline integration test</a> failed. If you want to pull anyway, use flag "force" in addition to webhook.');
      }
    }
    
    $Path=dirname(__FILE__);
    $Path=str_replace('/core','',$Path);
    
    $Command = 'cd '.$Path.' && git reset --hard && git pull';
    
    echo 'Pulling Mainline Repo...<br><br><pre style="border: 1px solid #c7c7c7;">';
    echo shell_exec($Command);
    echo '</pre><a href="/architect" class="btn btn-success">Architect</a>';
    
    /* ?>
<p>Redirecting to architect...</p>
<script>
  window.setTimeout(function(){
    window.location.href = "/architect";
  }, 1000);
</script>

    <?php */
    
}
