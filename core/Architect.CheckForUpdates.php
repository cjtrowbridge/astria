<?php

Hook('Architect Notifications','Architect_CheckForUpdates();');
Hook('User Is Logged In','Architect_MaybeCheckForUpdates();');

function Architect_MaybeCheckForUpdates(){
  if(isset($_GET['checkForUpdates'])){
    if(
      IsAstriaAdmin()
    ){
      Architect_CheckNowForUpdates();
      exit;
    }else{
      die('You do not have permission to check for updates. ');
    }
  }
}

function Architect_CheckForUpdates(){
  ?>
<span id="checkForUpdates"><span id="updatesChecker"><img src="/img/ajax-loader.gif" title="Checking For Updates..."></span></span>
<script>
  $.get("/?checkForUpdates",function(data){
    $('#updatesChecker').html(data);
  });
</script>

  <?php
}

function Architect_CheckNowForUpdates(){
  Event("Begining Checking For Updates");
  global $ASTRIA;
  $Local  = gitLocalHash();
  $Global = gitGlobalHash();

  if(!($Local==$Global)){
    echo '<a href="'.$ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')).'"><i class="material-icons" title="Updates Available" style="color: red;">system_update_alt</i></a>';
    echo PHP_EOL.PHP_EOL.'<!--';
    echo PHP_EOL.'Local Master Head is at:  '.$Local.PHP_EOL;
    echo PHP_EOL.'Global Master Head is at: '.$Global.PHP_EOL;
    echo '-->'.PHP_EOL.PHP_EOL;
    /* ?>

  <div class="card">
    <div class="card-block">
      <div class="card-text" id="updatesChecker">
        <h2>Updates are Available!</h2>
        <a href="<?php echo $ASTRIA['app']['appURL'].'/?'.urlencode(BlowfishEncrypt('Pull Mainline From Github')); ?>">Pull Mainline From Github, pending an integration test.</a>
        <p>Local Master Head is at: <?php echo $Local; ?></p>
        <p>Global Master Head is at: <?php echo $Global; ?></p>
      </div>
    </div>
  </div>

    <?php */
  }else{
    ?><i class="material-icons" title="Up To Date">done</i><?php
  }
  Event("Done Checking For Updates");
}
