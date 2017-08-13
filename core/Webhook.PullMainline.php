<?php

Hook('Webhook','RepoPull();');

function RepoPull(){
  
  //TODO figure out some kind of automated integration test to put in here
  
  $MagicWord=BlowfishEncrypt('Pull Mainline From Github');
  if(
    isset($_GET[$MagicWord])
  ){
    
    $AstriaMainlineIntegrationTest = file_get_contents('https://astria.io/test/integration');
    if(!($AstriaMainlineIntegrationTest=='ok')){
      if(!(isset($_GET['force']))){
        die('Astria mainline integration test failed. If you want to pull anyway, use flag "force" in addition to webhook.');
      }
    }
    
    $Path=dirname(__FILE__);
    $Path=str_replace('/core','',$Path);
    
    $Command = 'cd '.$Path.' && git reset --hard && git pull';
    
    echo 'Pulling Mainline Repo...<br>';
    echo shell_exec($Command);
    
    ?>
<p>Redirecting to architect in five seconds...</p>
<script>
  window.setTimeout(function(){
    window.location.href = "/architect";
  }, 5000);
</script>

    <?php
    
    exit;
  }
}
